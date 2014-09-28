<?php

class Query {
  protected $connection;
  protected $statement;
  protected $table;
  protected $columns;
  protected $where = [];
  protected $limit;
  protected $offset;
  protected $order;
  protected $orderDirection;
  protected $group;
  protected $groupDirection;
  protected $values = [];

  public function __construct(PDO &$connection, $table, 
      array $columns = array('*')) {
    $this->connection = $connection;
    $this->table = $table;
    $this->columns = $columns;
  }

  public function __destruct() {
    $this->connection = NULL;
    $this->statement = NULL;
  }

  public function where($column, $value, $comparator = '=', $operator = 'AND') {
    $this->where[] = "{$operator} {$column} {$comparator} :where_{$column}";
    
    try {
      $this->addValue($value, "where_{$column}");
    } catch (InvalidArgumentException $e) {
      throw $e;
    }
    
    return $this;
  }

  public function in($column, array $values) {
    $placeholder = '?';
    
    for ($i = count($values); $i > 0; $i --) {
      $placeholder .= ', ?';
    }
    
    $this->where[] = "IN {$column} IN ({$placeholder})";
    
    try {
      foreach ($values as $value) {
        $this->addValue($value);
      }
    } catch (InvalidArgumentException $e) {
      throw $e;
    }
    
    return $this;
  }

  public function order($column, $direction = 'ASC') {
    $this->order = $column;
    $this->orderDirection = $direction;
    
    return $this;
  }

  public function group($column, $direction = 'ASC') {
    $this->group = $column;
    $this->groupDirection = $direciton;
    
    return $this;
  }

  public function limit($limit, $offset = null) {
    $this->limit = $limit;
    
    if (isset($offset)) $this->offset = $offset;
    
    return $this;
  }

  protected function whereClause() {
    $where = 'WHERE ';
    $arraySize = sizeof($this->$where);
    
    if ($arraySize == 1) {
      $where .= array_shift($this->where);
    } elseif ($arraySize > 1) {
      $first = array_shift($this->where);
      
      $where .= ltrim(strstr($first, ' '));
      
      foreach ($this->where as $clause) {
        $where .= " {$clause}";
      }
    }
    
    return $where;
  }

  protected function groupClause() {
    $group = '';
    
    if (isset($this->group)) $group = "GROUP BY {$this->group} {$this->orderDirection}";
    
    return $group;
  }

  protected function orderClause() {
    $order = '';
    
    if (isset($this->order)) $order = "ORDER BY {$this->order} {$this->groupDirection}";
    
    return $order;
  }

  protected function limitClause() {
    $limit = '';
    
    if (isset($this->limit)) $limit = "LIMIT {$this->limit}";
    if (isset($this->offset)) $limit .= ",{$this->offset}";
    
    return $limit;
  }

  protected function buildSelect() {
    $template = "SELECT %s FROM %s %s %s %s %s";
    $columns = implode(', ', $this->columns);
    $table = $this->table;
    $where = $this->whereClause();
    $group = $this->groupClause();
    $order = $this->orderClause();
    $limit = $this->limitClause();
    $query = trim(
        sprintf($template, $columns, $table, $where, $group, $order, $limit));
    
    return $query;
  }

  protected function buildInsert(array $data) {
    $template = "INSERT INTO %s (%s) VALUES (%s)";
    $columns = [];
    $values = [];
    
    foreach ($data as $column => $value) {
      try {
        $this->addValue($value, $column);
      } catch (InvalidArgumentException $e) {
        throw $e;
      }
      
      $columns[] = (string) $column;
      $values[] = ":{$column}";
    }
    
    $table = $this->table;
    $columns = implode(', ', $columns);
    $values = implode(', ', $values);
    $query = trim(sprintf($template, $table, $columns, $values));
    
    return $query;
  }

  protected function buildUpdate(array $data) {
    $template = "UPDATE %s SET %s %s %s";
    $columns = [];
    
    foreach ($data as $column => $value) {
      try {
        $this->addValue($value, $column);
      } catch (InvalidArgumentException $e) {
        throw $e;
      }
      
      $columns[] = "{$column} = :{$column}";
    }
    
    $table = $this->table;
    $columns = implode(', ', $columns);
    $where = $this->whereClause();
    $limit = $this->limitClause();
    $query = trim(sprintf($template, $table, $columns, $where, $limit));
    
    return $query;
  }

  protected function buildDelete() {
    $template = "DELETE FROM %s %s %s";
    $table = $this->table;
    $where = $this->whereClause();
    $limit = $this->limitClause();
    $query = trim(sprintf($template, $table, $where, $limit));
    
    return $query;
  }

  protected function addValue($value, $column = null) {
    if (empty($column)) {
      $this->values[] = $value;
    } else {
      $column = ":{$column}";
      $this->values[$column] = $value;
    }
  }

  protected function setFetchMode($fetchMode, $options = null) {
    try {
      ($options) ? $this->statement->setFetchMode($fetchMode, $options) : $this->statement->setFetchMode(
          $fetchMode);
    } catch (PDOException $e) {
      throw $e;
    }
  }

  protected function prepare($query) {
    try {
      $this->statement = $this->connection->prepare($query);
    } catch (PDOException $e) {
      throw $e;
    }
  }

  protected function execute() {
    try {
      $this->statement->execute($this->values);
    } catch (PDOException $e) {
      throw $e;
    }
  }

  public function resultClass($class) {
    try {
      $query = $this->buildSelect();
      $this->prepare($query);
      $this->setFetchMode(PDO::FETCH_CLASS, $class);
      $this->execute();
    } catch (Exception $e) {
      throw $e;
    }
    
    return $this->statement;
  }

  public function resultBoth() {
    try {
      $query = $this->buildSelect();
      $this->prepare($query);
      $this->setFetchMode(PDO::FETCH_BOTH);
      $this->execute();
    } catch (Exception $e) {
      throw $e;
    }
    
    return $this->statement;
  }

  public function save(array $data) {
    try {
      $query = (empty($this->where)) ? $this->buildUpdate($data) : $this->buildInsert(
          $data);
      $this->prepare($query);
      $this->execute();
    } catch (Exception $e) {
      throw $e;
    }
    
    return $this->statement;
  }

  public function delete() {
    try {
      $query = $this->buildDelete();
      $this->prepare($query);
      $this->execute();
    } catch (Exception $e) {
      throw $e;
    }
  }
}

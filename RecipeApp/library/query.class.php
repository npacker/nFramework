<?php

class Query {
  protected $columns;
  protected $connection;
  protected $group;
  protected $groupDirection;
  protected $limit;
  protected $offset;
  protected $order;
  protected $orderDirection;
  protected $statement;
  protected $table;
  protected $values = array();
  protected $where = array();

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

  public function constrain($column, $value, $operator = 'AND', $comparator = '=') {
    if (empty($this->where)) {
      $this->where[] = "{$column} {$comparator} :where_{$column}";
    } else {
      $this->where[] = "{$operator} {$column} {$comparator} :where_{$column}";
    }
    
    $this->addValue($value, "where_{$column}");
    
    return $this;
  }
  
  public function constrainOr($column, $value, $comparator = '=') {
    return $this->constrain($column, $value, 'OR', $comparator);
  }
  
  public function constrainAnd($column, $value, $comparator = '=') {
    return $this->constrain($column, $value, 'AND', $comparator);
  }

  public function in($column, array $values) {
    $placeholder = '?';
    
    for ($i = count($values); $i > 0; $i--) {
      $placeholder .= ', ?';
    }
    
    $this->where[] = "IN {$column} IN ({$placeholder})";
    
    foreach ($values as $value) {
      $this->addValue($value);
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
    $where = '';
    
    if (!empty($this->where)) {
      $first_clause = array_shift($this->where);
      $first_clause = ltrim($first_clause, 'AND');
      $first_clause = ltrim($first_clause, 'OR');
      $where = 'WHERE ' . $first_clause;
      
      foreach ($this->where as $clause) {
        $where .= ' ' . $clause;
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
      $this->addValue($value, $column);
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
      $this->addValue($value, $column);
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
    ($options) ? $this->statement->setFetchMode($fetchMode, $options) : $this->statement->setFetchMode(
        $fetchMode);
  }

  protected function prepare($query) {
    $this->statement = $this->connection->prepare($query);
  }

  protected function execute() {
    $this->statement->execute($this->values);
  }

  public function resultClass($class) {
    $query = $this->buildSelect();
    $this->prepare($query);
    $this->setFetchMode(PDO::FETCH_CLASS, $class);
    $this->execute();
    
    return $this->statement;
  }

  public function resultBoth() {
    $query = $this->buildSelect();
    $this->prepare($query);
    $this->setFetchMode(PDO::FETCH_BOTH);
    $this->execute();
    
    return $this->statement;
  }

  public function save(array $data) {
    if (empty($this->where)) {
      $query = $this->buildInsert($data);
    } else {
      $query = $this->buildUpdate($data);
    }

    $this->prepare($query);
    $this->execute();
    
    return $this->statement;
  }

  public function delete() {
    $query = $this->buildDelete();
    $this->prepare($query);
    $this->execute();
    
    return $this->statement;
  }
}

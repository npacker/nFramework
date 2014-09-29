<?php

class Query {
  protected $columns;
  protected $connection;
  protected $constraintClauses = array();
  protected $constraintValues = array();
  protected $dataValues = array();
  protected $group;
  protected $groupDirection;
  protected $limit;
  protected $offset;
  protected $order;
  protected $orderDirection;
  protected $statement;
  protected $table;
  protected $query;

  public function __construct(PDO &$connection, $table, array $columns = array('*')) {
    $this->connection = $connection;
    $this->table = $table;
    $this->columns = $columns;
  }

  public function __destruct() {
    $this->connection = null;
    $this->statement = null;
  }

  public function constrain($column, $value, $comparator = '=', $operator = 'AND') {
    if (empty($this->constraintClauses)) {
      $this->constraintClauses[] = "{$column} {$comparator} ?";
    } else {
      $this->constraintClauses[] = "{$operator} {$column} {$comparator} ?";
    }
    
    $this->addConstraintValue($value);
    
    return $this;
  }
  
  public function constrainOr($column, $value, $comparator = '=') {
    return $this->constrain($column, $value, $comparator, 'OR');
  }
  
  public function constrainAnd($column, $value, $comparator = '=') {
    return $this->constrain($column, $value, $comparator, 'AND');
  }

  public function in($column, array $values) {
    $placeholder = ltrim(str_repeat(', ?', count($values)), ', ');
    $this->constraintClauses[] = "IN {$column} IN ({$placeholder})";
    
    foreach ($values as $value) {
      $this->addConstraintValue($value);
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
    
    if (!empty($this->constraintClauses)) {
      $where = 'WHERE';
      
      foreach ($this->constraintClauses as $clause) {
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
    
    if (isset($this->order)) $order = "ORDER BY {$this->order} {$this->orderDirection}";
    
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
    $query = trim(sprintf($template, $columns, $table, $where, $group, $order, $limit));
    
    return $query;
  }

  protected function buildInsert(array $data) {
    $template = "INSERT INTO %s (%s) VALUES (%s)";
    $columns = array();
    $placeholder = ltrim(str_repeat(', ?', count($data)), ', ');
    
    foreach ($data as $column => $value) {
      $this->addDataValue($value);
      $columns[] = (string) $column;
    }
    
    $table = $this->table;
    $columns = implode(', ', $columns);
    $query = trim(sprintf($template, $table, $columns, $placeholder));
    
    return $query;
  }

  protected function buildUpdate(array $data) {
    $template = "UPDATE %s SET %s %s %s";
    $columns = array();
    
    foreach ($data as $column => $value) {
      $this->addDataValue($value);
      $columns[] = "{$column} = ?";
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

  protected function addConstraintValue($value) {
    $this->constraintValues[] = $value;
  }
  
  protected function addDataValue($value) {
    $this->dataValues[] = $value;
  }

  protected function setFetchMode($fetchMode, $options = null) {
    if (isset($options)) {
      $this->statement->setFetchMode($fetchMode, $options);
    } else {
      $this->statement->setFetchMode($fetchMode);
    }
  }
  
  protected function inputParameters() {
    return array_merge($this->dataValues, $this->constraintValues);
  }

  protected function prepare($query) {
    $this->statement = $this->connection->prepare($query);
  }

  protected function execute() {
    $this->statement->execute($this->inputParameters());
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
    if (empty($this->constraintClauses)) {
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

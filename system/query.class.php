<?php

class Query {

  protected $connection;

  protected $query;

  protected $statement;

  public function __construct(PDO &$connection, $query) {
    $this->connection = &$connection;
    $this->statement = $this->connection->prepare($query);
  }

  public function __destruct() {
    unset($this->connection);
  }

  public function execute(array $data = array(), $fetchMode = PDO::FETCH_ASSOC, DomainObject $object = null) {
    $this->statement->setFetchMode($fetchMode, $object);
    $this->statement->execute($data);

    return $this->statement;
  }

  public function lastInsertId() {
    return  $this->connection->lastInsertId();
  }

}
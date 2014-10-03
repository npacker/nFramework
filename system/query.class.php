<?php

class Query {

  protected $connection;

  protected $query;

  protected $statement;

  public function __construct(PDO &$connection, $query) {
    $this->connection = & $connection;
    $this->statement = $this->connection->prepare($query);
    $this->statement->setFetchMode(PDO::FETCH_ASSOC);
  }

  public function __destruct() {
    unset($this->connection);
  }

  public function execute(array $data = array()) {
    $this->statement->execute($data);

    return $this->statement;
  }

}
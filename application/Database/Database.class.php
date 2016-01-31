<?php

namespace nFramework\Database;

use PDO;

abstract class Database {

  private $connection;

  private $dsn;

  private $hostname;

  private $database;

  private $username;

  private $password;

  final public function __construct($hostname, $database, $username, $password) {
    $this->hostname = $hostname;
    $this->database = $database;
    $this->username = $username;
    $this->password = $password;
    $this->prefix = $this->prefix();
    $this->dsn = "{$this->prefix}:host={$this->hostname};dbname={$this->database}";
  }

  final public function connect() {
    $this->connection = new PDO($this->dsn, $this->username, $this->password);
    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  final public function close() {
    unset($this->connection);
  }

  final public function query($query) {
    return new Query($this->connection, $query);
  }

  abstract protected function prefix();

}

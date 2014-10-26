<?php

namespace nFramework\Application\Database;

use PDO;

abstract class Database {

  protected static $instance = null;

  protected $connection;

  protected $dsn;

  protected $hostname;

  protected $database;

  protected $username;

  protected $password;

  final private function __clone() {}

  final private function __sleep() {}

  final private function __construct($hostname, $database, $username, $password) {
    $this->hostname = $hostname;
    $this->database = $database;
    $this->username = $username;
    $this->password = $password;
    $this->prefix = $this->prefix();
    $this->dsn = "{$this->prefix}:host={$this->hostname};dbname={$this->database}";
  }

  public static function instance($hostname, $database, $username, $password) {
    if (is_null(static::$instance)) static::$instance = new static(
        $hostname,
        $database,
        $username,
        $password);

    return static::$instance;
  }

  public function connect() {
    $this->connection = new PDO($this->dsn, $this->username, $this->password);
    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public function close() {
    unset($this->connection);
  }

  public function query($query) {
    return new Query($this->connection, $query);
  }

  abstract protected function prefix();

}
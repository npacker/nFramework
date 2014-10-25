<?php

class MySqlDatabase {

  protected static $instance = null;

  protected $connection;

  protected $dsn;

  protected $hostname;

  protected $database;

  protected $username;

  protected $password;

  protected function __construct($hostname, $database, $username, $password) {
    $this->hostname = $hostname;
    $this->database = $database;
    $this->username = $username;
    $this->password = $password;
    $this->dsn = "mysql:host={$this->hostname};dbname={$this->database}";
  }

  final private function __clone() {}

  final private function __sleep() {}

  public static function instance($hostname, $database, $username, $password) {
    if (is_null(self::$instance)) self::$instance = new self(
      $hostname,
      $database,
      $username,
      $password);

    return self::$instance;
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

}
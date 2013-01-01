<?php

class MySqlDatabase {

	protected static $instance = null;
	protected $hostname;
	protected $database;
	protected $username;
	protected $password;
	protected $dsn;
	protected $connection;

	protected function connect() {
		try {
			$this->connection = new PDO($this->dsn, $this->username, $this->password);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}
	}

	protected function __construct($hostname='localhost', $database, $username, $password) {
		$this->hostname = $hostname;
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
		$this->dsn = "mysql:host={$this->hostname};dbname={$this->database}";
		$this->connect();
	}

	public static function instance($hostname, $database, $username, $password) {
		if (is_null(self::$instance)) self::$instance = new self($hostname, $database, $username, $password);

		return self::$instance;
	}

	public function query() {
		return new Query($this->connection);
	}

}
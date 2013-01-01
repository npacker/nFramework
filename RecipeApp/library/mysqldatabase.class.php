<?php

class MySqlDatabase {

	protected static $instance = null;
	protected $hostname;
	protected $database;
	protected $username;
	protected $password;
	protected $dsn;
	protected $connection;

	protected function __construct($hostname, $database, $username, $password) {
		$this->hostname = $hostname;
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
		$this->dsn = "mysql:host={$this->hostname};dbname={$this->database}";
	}

	public function __destruct() {
		unset($this->connection);
	}

	final private function __clone() {}

	final private function __sleep() {}

	public static function instance($hostname, $database, $username, $password) {
		if (is_null(self::$instance)) self::$instance = new self($hostname, $database, $username, $password);

		return self::$instance;
	}

	public function connect() {
		try {
			$this->connection = new PDO($this->dsn, $this->username, $this->password);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}
	}

	public function close() {
		unset($this->connection);
	}

	public function query() {
		try {
			$query = new Query($this->connection);
		} catch (FileNotFoundException $e) {
			echo $e->getMessage();
			exit();
		}

		return $query;
	}

}
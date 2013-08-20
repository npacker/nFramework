<?php

class MySqlDatabase extends Base {

	protected static $instance = null;
	protected $hostname;
	protected $database;
	protected $username;
	protected $password;
	protected $dsn;
	protected $connection;

	protected function __construct($hostname, $database, $username, $password) {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->hostname = $hostname;
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
		$this->dsn = "mysql:host={$this->hostname};dbname={$this->database}";
	}

	public function __destruct() {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->close();
	}

	final private function __clone() {}

	final private function __sleep() {}

	public static function instance($hostname, $database, $username, $password) {
		echo 'Called ' . __METHOD__ . "<br />";
		if (is_null(self::$instance)) self::$instance = new self($hostname, $database, $username, $password);

		return self::$instance;
	}

	public function connect() {
		echo 'Called ' . __METHOD__ . "<br />";
		try {
			$this->connection = new PDO($this->dsn, $this->username, $this->password);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function close() {
		echo 'Called ' . __METHOD__ . "<br />";
		unset($this->connection);
	}

	public function query($table, array $columns=array('*')) {
		echo 'Called ' . __METHOD__ . "<br />";
		try {
			$query = new Query($this->connection, $table, $columns);
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		return $query;
	}

}

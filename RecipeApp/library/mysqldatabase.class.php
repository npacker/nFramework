<?php

class MySqlDatabase {

	protected static $instance = null;
	protected $connection;
	protected $statement;

	protected function __construct() {
		$dsn = 'mysql:host=' . DB_HOSTNAME . ';dbname=' . DB_DATABASE;

		try {
			$this->connection = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}
	}

	public static function instance() {
		if (is_null(self::$instance)) self::$instance = new self();
		return self::$instance;
	}

	function test() {
		$this->querySelect(array(
			"table" => "recipes",
			"columns" => array("name"),
			"where"	=> array("id" => $id),
		));
	}

	protected function prepare($query) {
		$this->statement = $this->connection->prepare($query);
	}

	protected function bindParam($parameter, $variable) {
		$this->statement->bindParam($parameter, $variable);
	}

	protected function execute() {
		$this->statement->execute();
	}

	protected function fetchClass($class) {
		$this->statement->setFetchMode(PDO::FETCH_CLASS, $class);
	}

}
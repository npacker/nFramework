<?php

class MySqlConnection {

	final private function __construct() {}

	final private function __clone() {}

	public static function getConnection() {
		echo 'Called ' . __METHOD__ . "<br />";
		$dsn = 'mysql:host=' . DB_HOSTNAME . ';dbname=' . DB_DATABASE;

		try {
			$connection = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}

		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $connection;
	}

}
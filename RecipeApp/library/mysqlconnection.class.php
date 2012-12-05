<?php

class MySqlConnection {

	public static function getConnection() {
		try {
			$dsn = 'mysql:host=' . DB_HOSTNAME . ';dbname=' . DB_DATABASE;
			$connection = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $connection;
	}

}
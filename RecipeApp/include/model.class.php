<?php

abstract class Model {

	protected $connection;

	public function __construct() {
		echo 'Called ' . __METHOD__ . "<br />";

		try {
			$this->connection = MySqlConnection::getConnection();
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}
	}

	abstract public function find($id);

	abstract public function join($id, $field);

	abstract public function all();

	abstract public function create();

	abstract public function update($id);

	abstract public function delete($id);

}
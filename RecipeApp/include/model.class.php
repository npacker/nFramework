<?php

abstract class Model {

	protected $database;

	public function __construct() {
		try {
			$this->database = MySqlDatabase::instance(DB_HOSTNAME, DB_DATABASE, DB_USERNAME, DB_PASSWORD);
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
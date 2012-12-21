<?php

abstract class Model {

	protected $connection;

	public function __construct() {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->connection = MySqlConnection::getConnection();
	}

	abstract public function get($id);

	abstract public function join($id, $field);

	abstract public function all();

	abstract public function create(Array $data);

	abstract public function update($id, Array $data);

	abstract public function delete($id);

}
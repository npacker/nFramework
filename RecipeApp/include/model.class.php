<?php

abstract class Model {

	protected $connection;

	public function __construct() {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->connection = MySqlConnection::getConnection();
	}

	abstract public function view($id);

	abstract public function viewRel($id, $field);

	abstract public function viewAll();

	abstract public function create(Array $data);

	abstract public function update($id, Array $data);

	abstract public function delete($id);

}
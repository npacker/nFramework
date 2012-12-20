<?php

abstract class Model {

	protected $connection;

	public function __construct() {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->connection = MySqlConnection::getConnection();
	}

	abstract public function view($id=null);

	abstract public function viewRel($id, $field);

	abstract public function create();

	abstract public function update($id);

	abstract public function delete($id);

}
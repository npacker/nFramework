<?php

abstract class Model {

	protected $connection;

	public function __construct() {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->connection = MySqlConnection::getConnection();
	}

	abstract public function view($id);

	abstract public function edit($id);

	abstract public function create($id);

	abstract public function update($id);

	abstract public function delete($id);

	public function getProperites() {
		return get_object_vars($this);
	}

}
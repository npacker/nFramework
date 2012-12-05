<?php

abstract class Model {

	protected $connection = MySqlConnection::getConnection();

	abstract public function view($id);

	abstract public function viewAll();

	abstract public function create($id);

	abstract public function update($id);

	abstract public function delete($id);

}
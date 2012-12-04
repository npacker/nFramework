<?php

abstract class Model {

	protected $connection = MySqlConnection::getConnection;

	abstract public function view();

	abstract public function create();

	abstract public function update();

	abstract public function delete();

}
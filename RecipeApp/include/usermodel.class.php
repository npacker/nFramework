<?php

Class UserModel extends Model {

	public function __construct() {

		echo 'Called ' . __METHOD__ . "<br />";

		parent::__construct();
	}

	public function get($id) {}

	public function join($id, $field) {}

	public function all() {}

	public function create(Array $data) {}

	public function update($id, Array $data) {}

	public function delete($id) {}

	public function authenticate($password) {}

}
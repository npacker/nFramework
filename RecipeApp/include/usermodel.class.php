<?php

Class UserModel extends Model {

	public function __construct() {
		echo 'Called ' . __METHOD__ . "<br />";
		parent::__construct();
	}

	public function find($id) {}

	public function join($id, $field) {}

	public function all() {}

	public function create(User $user=null) {}

	public function update($id, User $user=null) {}

	public function delete($id) {}

}
<?php

class CookbookModel extends Model {

	public function view($id) {}

	abstract public function viewRel($id, $field);

	public function create() {}

	public function update($id) {}

	public function delete($id) {}

}
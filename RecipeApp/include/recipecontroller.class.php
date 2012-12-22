<?php

class RecipeController extends Controller {

	public function __construct() {
		echo 'Called ' . __METHOD__ . "<br />";
		parent::__construct();
		$this->model = new RecipeModel();
	}

	public function view($id) {
		echo 'Called ' . __METHOD__ . "<br />";

		try {
			validateId($id);
		} catch (InvalidArgumentException $e) {
			throw $e;
		}

		if (isset($id)) $this->prepare($this->model->find($id));
		else $this->prepare($this->model->all());
	}

	public function create() {
		echo 'Called ' . __METHOD__ . "<br />";
		if (!empty($_POST)) $this->prepare($this->model->create($_POST));
	}

	public function update($id) {
		echo 'Called ' . __METHOD__ . "<br />";

		try {
			validateId($id);
		} catch (InvalidArgumentException $e) {
			throw $e;
		}

		if (!empty($_POST)) $this->prepare($this->model->update($id, $_POST));
	}

	public function delete($id) {
		echo 'Called ' . __METHOD__ . "<br />";

		try {
			validateId($id);
		} catch (InvalidArgumentException $e) {
			throw $e;
		}

		$this->prepare($this->model->delete($id));
	}

	protected function validateId($id) {
		if (!is_numeric($id)) Throw new InvalidArgumentException("$id is not numeric.");
	}

}
<?php

class RecipeController extends Controller {

	public function __construct() {
		echo 'Called ' . __METHOD__ . "<br />";
		parent::__construct();
		$this->model = new RecipeModel();
	}

	public function view($id) {
		echo 'Called ' . __METHOD__ . "<br />";

		if (!is_numeric($id) && !is_null($id)) {
			throw new InvalidArgumentException("$id is not numeric.");
			return;
		}

		if (isset($id)) $this->prepare($this->model->find($id));
		else $this->prepare($this->model->all());
	}

	public function create() {
		echo 'Called ' . __METHOD__ . "<br />";

		$this->prepare($this->model->create($_POST));
	}

	public function update($id) {
		echo 'Called ' . __METHOD__ . "<br />";

		if (!is_numeric($id) && !is_null($id)) {
			throw new InvalidArgumentException("$id is not numeric.");
			return;
		}

		$this->prepare($this->model->update($id, $_POST));
	}

	public function delete($id) {
		echo 'Called ' . __METHOD__ . "<br />";

		if (!is_numeric($id) && !is_null($id)) {
			throw new InvalidArgumentException("$id is not numeric.");
			return;
		}

		$this->prepare($this->model->delete($id));
	}

}
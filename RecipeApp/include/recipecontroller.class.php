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
			$this->validateId($id);
		} catch (InvalidArgumentException $e) {
			throw $e;
			return;
		}

		if (isset($id)) $this->prepare($this->model->find($id));
		else $this->prepare($this->model->all());
	}

	public function create() {
		echo 'Called ' . __METHOD__ . "<br />";

		$name = Request::post('name');
		$recipe = new Recipe($name);
		$this->prepare($this->model->create($name));
	}

	public function update($id) {
		echo 'Called ' . __METHOD__ . "<br />";

		try {
			$this->validateId($id);
		} catch (InvalidArgumentException $e) {
			throw $e;
			return;
		}

		$name = Request::post('name');
		$recipe = new Recipe($name);
		$this->prepare($this->model->update($id, $name));
	}

	public function delete($id) {
		echo 'Called ' . __METHOD__ . "<br />";

		try {
			$this->validateId($id);
		} catch (InvalidArgumentException $e) {
			throw $e;
			return;
		}

		$this->prepare($this->model->delete($id));
	}

}
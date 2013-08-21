<?php

class RecipeController extends Controller {

	public function __construct() {
		echo 'Called ' . __METHOD__ . "<br />";
		parent::__construct();
		$this->model = new RecipeModel();
	}

	public function view($id=null) {
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
		$id = $this->model->create($recipe);
		$this->prepare($this->model->find($id));
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
		$this->model->update($id, $recipe);
		$this->prepare($this->model->find($id));
	}

	public function delete($id) {
		echo 'Called ' . __METHOD__ . "<br />";

		try {
			$this->validateId($id);
		} catch (InvalidArgumentException $e) {
			throw $e;
			return;
		}

		$this->model->delete($id);
		$this->prepare($this->model->all());
	}

}
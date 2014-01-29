<?php

class RecipeController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->model = new RecipeModel();
	}

	public function view($id=null) {
		try {
			$this->validateId($id);
		} catch (InvalidArgumentException $e) {

		}

		try {
			(isset($id)) ? $this->prepare($this->model->find($id)) : $this->prepare($this->model->all());
		} catch (Exception $e) {

		}
	}

	public function create() {
		$name = Request::post('name');
		$recipe = new Recipe($name);
		$id = $this->model->create($recipe);

		try {
			$this->prepare($this->model->find($id));
		} catch (Exception $e) {

		}
	}

	public function update($id) {
		try {
			$this->validateId($id);
		} catch (InvalidArgumentException $e) {

		}

		$name = Request::post('name');
		$recipe = new Recipe($name);
		$this->model->update($id, $recipe);
		$this->prepare($this->model->find($id));
	}

	public function delete($id) {
		try {
			$this->validateId($id);
		} catch (InvalidArgumentException $e) {

		}

		$this->model->delete($id);
		$this->prepare($this->model->all());
	}

}
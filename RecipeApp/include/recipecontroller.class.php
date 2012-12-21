<?php

Class RecipeController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->model = new RecipeModel();
	}

	public function view($id) {
		if (isset($id)) $this->prepare($this->model->get($id));
		else $this->prepare($this->model->all());
	}

	public function create() {
		if (!empty($_POST)) $this->prepare($this->model->create($_POST));
	}

	public function update($id) {
		if (!empty($_POST)) $this->prepare($this->model->update($id, $_POST));
	}

	public function delete($id) {
		$this->prepare($this->model->delete($id));
	}

}
<?php

class RecipeController extends Controller {

	public function __construct() {
		$this->model = new RecipeModel();
	}

	public function view(array $args) {
	  $this->setTemplate('view');
    $this->prepare($this->model->find($args[0]));
	}

}
<?php

class RecipeController extends Controller {

	public function __construct() {
		$this->model = new RecipeModel();
	}

	public function view(array $args) {
    $recipe = $this->model->find($args[0]);

    $data = array();

    $data['page_title'] = $recipe->getTitle();
    $data['page'] = new Template('recipe/view', $recipe);

    return $data;
	}

}
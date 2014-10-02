<?php

class RecipeController extends Controller {

	public function __construct() {
		$this->model = new RecipeModel();
	}

	public function view(array $args = array()) {
	  if ($args['path_argument'] == 'all') {
	    return $this->viewAll($args);
	  }

    $recipe = $this->model->find($args['path_argument']);

    if (empty($recipe)) {
      throw new Exception();
    }

    $data['page_title'] = $recipe['title'];
    $data['page'] = new Template('recipe/view', $recipe);

    return $data;
	}

	public function viewAll(array $args = array()) {
    $recipes = $this->model->all();

    $data['page_title'] = 'All Recipes';
    $data['page'] = new Template('recipe/index', array('recipes' => $recipes, 'base_url' => base_url(), 'base_path' => base_path()));

    return $data;
	}

}
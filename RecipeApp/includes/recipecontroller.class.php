<?php

class RecipeController extends Controller {

	public function __construct() {
		$this->model = new RecipeModel();
	}

	public function view(array $args = array()) {
	  $id = $args['path_argument'];

	  if ($id == 'all') {
	    $data = $this->all($args);
	  } else {
      $recipe = $this->model->find($id);

      if (empty($recipe)) {
        throw new Exception();
      }

      $ingredientController = new IngredientController();
      extract($ingredientController->view(array('recipe_id' => $id)));

      $recipe['ingredients'] = $ingredients;

      $data['title'] = $recipe['title'];
      $data['content'] = new Template('recipe/view', $recipe);
      $data['template'] = 'html';
	  }

    return $data;
	}

	public function all(array $args = array()) {
    $recipes = $this->model->all();

    $data['title'] = 'All Recipes';
    $data['content'] = new Template('recipe/index', array('recipes' => $recipes, 'base_url' => base_url(), 'base_path' => base_path()));
    $data['template'] = 'html';

    return $data;
	}

}
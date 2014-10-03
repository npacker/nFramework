<?php

class RecipeController extends Controller {

  public function __construct() {
    $this->model = new RecipeModel();
  }

  public function view(array $args = array()) {
    $id = $args['path_argument'];

    if ($id == 'all') {
      return $this->all($args);
    }

    $recipe = $this->model->find($id);

    if (empty($recipe)) {
      throw new Exception("The recipe could not be found.");
    }

    $ingredients = new IngredientController();
    $ingredientData = $ingredients->view(array('recipe_id' => $id));
    $recipe['ingredients'] = $ingredientData['content'];

    $data['title'] = $recipe['title'];
    $data['content'] = new Template('recipe/view', $recipe);
    $data['template'] = 'html';

    return $data;
  }

  public function all(array $args = array()) {
    $recipes = $this->model->all();

    $data['title'] = 'All Recipes';
    $data['content'] = new Template(
      'recipe/index',
      array(
        'recipes' => $recipes,
        'base_url' => base_url(),
        'base_path' => base_path()));
    $data['template'] = 'html';

    return $data;
  }

}
<?php

class IngredientController extends Controller {

  public function __construct() {
    $this->model = new IngredientModel();
  }

  public function view(array $args = array()) {
    if (isset($args['recipe_id'])) {
      $ingredients = $this->model->recipe($args['recipe_id']);

      $data['ingredients'] = new Template('ingredient/index', array('ingredients' => $ingredients));
    } else {
      $ingredient = $this->model->find($args['id']);

      $data['title'] = $ingredient['title'];
      $data['content'] = new Template('ingredient/view', $ingredient);
      $data['template'] = 'html';
    }

    return $data;
  }

}
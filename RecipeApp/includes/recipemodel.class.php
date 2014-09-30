<?php

class RecipeModel extends Model {

	public function find($id) {
		try {
		  $this->database->connect();
  		$recipe = $this->database->query('recipes', array('title'))
  			->constrain('id', $id)
  			->resultClass('Recipe')
  			->fetch();
  		$this->database->close();
		} catch (PDOException $e) {
		  throw $e;
		}

		return $recipe;
	}

	protected function ingredients($id, &$recipe) {
		try {
			$ingredientModel = new ingredientModel();
		} catch (FileNotFoundException $e) {
			echo $e->getMessage();
			exit();
		}

		$ingredients = $ingredientModel->join($id, 'recipe_id');

		foreach ($ingredients as $ingredient) {
			$recipe->addIngredient($ingredient);
		}
	}

}
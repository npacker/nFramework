<?php

class RecipeModel extends Model {

	public function find($id) {
	  $this->database->connect();
		$recipe = $this->database->query('recipes', array('title'))
			->constrain('id', $id)
			->resultClass('Recipe')
			->fetch();
		$this->database->close();

		return $recipe;
	}

	public function all() {
    $this->database->connect();
    $result = $this->database->query('recipes')
      ->resultClass('Recipe');
    $recipes = array();

    while ($recipe = $result->fetch()) {
      array_push($recipes, $recipe);
    }

    return $recipes;
	}

}
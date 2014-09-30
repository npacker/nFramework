<?php

class Recipe extends Entity {

	protected $ingredients = array();

	public function __construct($title=null, Array $ingredients=null) {
		if (isset($title)) $this->title = $title;
		if (isset($ingredients)) $this->ingredients = $ingredients;
	}

	public function addIngredient(Ingredient $ingredient) {
		array_push($this->ingredients, $ingredient);
	}

}
<?php

class Recipe extends Type {

	protected $name;
	protected $ingredients = array();

	public function __construct($name=null, Array $ingredients=null) {
		if (isset($name)) $this->name = $name;
		if (isset($ingredients)) $this->ingredients = $ingredients;
	}

	public function addIngredient(Ingredient $ingredient) {
		array_push($this->ingredients, $ingredient);
	}

}
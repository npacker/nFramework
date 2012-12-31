<?php

class Recipe extends Type {

	protected $name;
	protected $ingredients = array();

	public function __construct($name=null, Array $ingredients=null) {
		echo 'Called ' . __METHOD__ . "<br />";
		if (isset($name)) $this->name = $name;
		if (isset($ingredients)) $this->ingredients = $ingredients;
	}

	public function addIngredient(Ingredient $ingredient) {
		echo 'Called ' . __METHOD__ . "<br />";
		array_push($this->ingredients, $ingredient);
	}

}
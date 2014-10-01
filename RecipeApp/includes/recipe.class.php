<?php

class Recipe extends Entity {

  protected $id;
	protected $ingredients = array();

	public function __construct($id=null, $title=null, Array $ingredients=null) {
	  if (isset($id)) $this->id = $id;
		if (isset($title)) $this->title = $title;
		if (isset($ingredients)) $this->ingredients = $ingredients;
	}

	public function getId() {
	  return $this->id;
	}

	public function addIngredient(Ingredient $ingredient) {
		array_push($this->ingredients, $ingredient);
	}

}
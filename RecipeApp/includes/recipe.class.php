<?php

class Recipe extends Entity {

  protected $id;
	protected $ingredients = array();

	public function __construct($id=null, $title=null, array $ingredients=null) {
	  if (isset($id)) $this->id = $id;
		if (isset($title)) $this->title = $title;
		if (isset($ingredients)) $this->ingredients = $ingredients;
	}

	public function getId() {
	  return $this->id;
	}

	public function getIngredients() {
	  return $this->ingredients;
	}

}
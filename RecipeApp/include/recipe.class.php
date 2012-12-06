<?php

class Recipe {

	protected $name;
	protected $ingredients = array();

	public function __construct($name=null, Array $ingredients=null) {

		echo 'Called ' . __METHOD__ . "\n";

		if (isset($name)) $this->name = $name;
		if (isset($ingredients)) $this->ingredients = $ingredients;
	}

	public function name() {
		return $this->name;
	}

	public function ingredients() {
		return $this->ingredients;
	}

	public function setIngredients(Array $ingredients) {

		echo 'Called ' . __METHOD__ . "\n";

		$this->ingredients = $ingredients;
	}

}
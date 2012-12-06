<?php

class Recipe extends Node {

	protected $name;
	protected $ingredients = array();

	public function __construct($name=null, Array $ingredients=null) {

		echo 'Called ' . __METHOD__ . "<br />";

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

		echo 'Called ' . __METHOD__ . "<br />";

		$this->ingredients = $ingredients;
	}

}
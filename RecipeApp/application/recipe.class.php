<?php

class Recipe {

	protected $name;
	protected $ingredients = array();

	public function __construct($name, Array $ingredients) {
		$this->name = $name;
		$this->ingredients = $ingredients;
	}

	public function name() {
		return $this->name;
	}

	public function ingredients() {
		return $this->ingredients;
	}

}
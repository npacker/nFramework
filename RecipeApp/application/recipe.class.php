<?php

class Recipe {

	protected $name;
	protected $ingredients;
	protected $steps;

	public function __construct($name, Array $ingredients, Array $steps) {
		$this->name = $name;
		$this->ingredients = $ingredients;
		$this->steps = $steps;
	}

	public function name() {
		return $this->name;
	}

	public function ingredients() {
		return $this->ingredients;
	}

	public function steps() {
		return $this->steps;
	}

}
<?php

class Ingredient {

	protected $name;
	protected $quantity;

	public function __construct($name, $quantity) {
		$this->name = $name;
		$this->quantity = $quantity;
	}

	public function name() {
		return $this->name;
	}

	public function quantity() {
		return $this->quantity;
	}

}
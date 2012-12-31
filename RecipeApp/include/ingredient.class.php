<?php

class Ingredient extends Type {

	protected $name;
	protected $quantity;

	public function __construct($name=null, $quantity=null) {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->name = $name;
		$this->quantity = $quantity;
	}

}
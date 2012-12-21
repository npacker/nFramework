<?php

class Ingredient extends Type {

	protected $name;
	protected $quantity;

	public function __construct($name=null, $quantity=null) {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->name = $name;
		$this->quantity = $quantity;
	}

	public function name() {
		echo 'Called ' . __METHOD__ . "<br />";
		return $this->name;
	}

	public function quantity() {
		echo 'Called ' . __METHOD__ . "<br />";
		return $this->quantity;
	}

	public function setName($name) {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->name = $name;
	}

	public function setQuantity($quantity) {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->quantity = $quantity;
	}

}
<?php

class Template {

	protected $vars;

	public function __construct() {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->vars = array();
	}

	public function set($key, $value) {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->vars[$key] = $value;
	}

	public function render() {

		echo 'Called ' . __METHOD__ . "<br />";

		print_r($this->vars);

		echo "<br />";
	}

}
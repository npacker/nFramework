<?php

class Template {

	protected $vars;

	public function __construct() {
		$this->vars = array();

		echo 'Called ' . __METHOD__ . "<br />";

	}

	public function set($key, $value) {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->vars['$key'] = $value;
	}

	public function render() {

		echo 'Called ' . __METHOD__ . "<br />";

		print_r($this->vars);
	}

}
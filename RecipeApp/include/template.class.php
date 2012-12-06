<?php

class Template {

	protected $vars;

	public function __construct() {
		$this->vars = array();

		echo 'Called ' . __METHOD__ . "\n";

	}

	public function set($key, $value) {

		echo 'Called ' . __METHOD__ . "\n";

		$this->vars['$key'] = $value;
	}

	public function render() {

		echo 'Called ' . __METHOD__ . "\n";

		print_r($this->vars);
	}

}
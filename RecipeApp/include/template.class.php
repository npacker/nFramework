<?php

class Template {

	protected $vars;

	public function __construct() {
		$this->vars = array();

		echo 'Called ' . __METHOD__;

	}

	public function set($key, $value) {

		echo 'Called ' . __METHOD__;

		$this->vars['$key'] = $value;
	}

	public function render() {

		echo 'Called ' . __METHOD__;

		print_r($vars);
		echo 'Called render.';
	}

}
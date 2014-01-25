<?php

class View {

	protected $vars;

	public function __construct() {
		$this->vars = array();
	}

	public function set($key, $value) {
		$this->vars[$key] = $value;
	}

	public function render() {
		print_r($this->vars);
	}

}
<?php

class Template {

	protected $vars = array();

	public function set($key, $value) {
		$this->vars['$key'] = $value;
	}

	public function render() {
		print_r($vars);
		echo 'Called render.';
	}

}
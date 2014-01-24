<?php

class Dispatcher extends Base {

	protected $controller;
	protected $action;
	protected $args;

	public function __construct() {}

	public function setController($controller) {
			$controllerName =  substr_replace($controller, '', -1) . 'Controller';
			$this->controller = $controllerName;
	}

	public function setAction($action) {
		$this->action = $action;
	}

	public function setArgs(array $args) {
		$this->args = $args;
	}

	public function dispatch() {
		try {
			$controller = new $controllerName();
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		try {
			$id = $this->args[0];
			(empty($id)) ? $controller->$action() : $controller->$action($id);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function forward($controller, $action, array $args) {

	}

}
<?php

class Dispatcher extends Base {

	protected $default;
	protected $controller;
	protected $action;
	protected $args;

	public function __construct() {}

	public function setDefaultController($default) {
		$this->default = $default;
	}

	public function setController($controller) {
			if (empty($controller)) {
				$this->controller = $this->controllerName($this->default);
			} else {
				$this->controller = $this->controllerName($controller);
			}
	}

	public function setAction($action) {
		$this->action = $action;
	}

	public function setArgs(array $args) {
		$this->args = $args;
	}

	public function dispatch() {
		try {
			$controller = new $this->controller();
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

	protected function controllerName($controller) {
		return substr_replace($controller, '', -1) . 'Controller';
	}

}
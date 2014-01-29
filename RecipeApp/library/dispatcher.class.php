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

		if (!class_exits($this->controller)) {
			$httperror = new HttpError(404, Request::server('REQUEST_URI'));
			throw new HttpException($httperror);
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
			$id = $this->args[0];

			if (empty($id)) {
				$this->controller->$this->action();
			} else {
				$this->controller->$this->action($id);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			exit();
		}
	}

	public function forward($controller, $action, array $args) {

	}

	protected function controllerName($controller) {
		return substr_replace($controller, '', -1) . 'Controller';
	}

}
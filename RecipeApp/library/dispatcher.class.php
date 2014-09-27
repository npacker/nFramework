<?php

class Dispatcher extends Base {

	protected static $controller;
	protected static $action;
	protected static $args;

	final private function __construct() {}

	final private function __clone() {}

	public static function forward($controller, $action, array $args=array()) {
		self::setController($controller);
		self::setAction($action);
		self::setArgs($args);
	}

	public static function dispatch() {
		$action = self::$action;
		$id = self::$args[0];

		try {
			if (!method_exists($action, $controller)) {
				$httpError = new HttpError(404, Request::server('REQUEST_URI'));
				throw new HttpException($httpError);
			}
		} catch (HttpException $e) {
			self::forward('HttpError', 'index');
			self::dispatch();
		}

		try {
			if (empty($id)) {
				self::$controller->$action();
			} else {
				self::$controller->$action($id);
			}
		} catch (Exception $e) {
			self::forward('HttpError', 'index');
			self::dispatch();
		}
	}

	protected static function setController($controller) {
		$controller = self::controllerName($controller);

		try {
			if (class_exists(self::$controller)) {
				self::$controller = new $controller();
			} else {
				$httpError = new HttpError(404, Request::server('REQUEST_URI'));
				throw new HttpException($httpError);
			}
		} catch (HttpException $e) {
			self::forward('HttpError', 'index');
			self::dispatch();
		}
	}

	protected static function setAction($action) {
		self::$action = $action;
	}

	protected static function setArgs(array $args) {
		self::$args = $args;
	}

	protected static function controllerName($controller) {
		return substr_replace($controller, '', -1) . 'Controller';
	}

}
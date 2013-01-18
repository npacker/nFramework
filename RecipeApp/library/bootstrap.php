<?php

function __include_file($class) {
	$filename = strtolower($class);

	if (file_exists(ROOT . DS . 'library' . DS . $filename . '.class.php')) {
		require_once ROOT . DS . 'library' . DS . $filename . '.class.php';
	} else if (file_exists(ROOT . DS . 'include' . DS . $filename . '.class.php')) {
		require ROOT . DS . 'include' . DS . $filename . '.class.php';
	} else {
		throw new FileNotFoundException("Could not load {$filename}.");
	}

	if (!class_exists($class)) throw new Exception("Class {$class} is undefined.");
}

function pathInit() {
	echo 'Called ' . __FUNCTION__ . '<br />';
	$uri = Request::server('REQUEST_URI');
	$params = explode('/', trim($uri, '/'));
	$type = array_shift($params);
	$action = array_shift($params);
	$id = array_shift($params);

	try {
		route($type, $action, $id);
	} catch (BadMethodCallException $e) {
		echo $e->getMessage();
		exit();
	} catch (FileNotFoundException $e) {
		echo $e->getMessage();
		exit();
	} catch (Exception $e) {
		echo $e->getMessage();
		exit();
	}
}

function route($type, $action, $id) {
	echo 'Called ' . __FUNCTION__ . '<br />';

	$controllerName = substr_replace($type, '', -1) . 'Controller';

	try {
		$controller = new $controllerName();
	} catch (FileNotFoundException $e) {
		throw $e;
	}

	if (method_exists($controller, $action)) {
		try {
			(empty($id)) ? $controller->$action() : $controller->$action($id);
		} catch (Exception $e) {
			throw $e;
		}
	}	else throw new BadMethodCallException('Action not defined.');
}

function bootstrapInit() {
	echo 'Called ' . __FUNCTION__ . '<br />';
	require_once (ROOT . DS . 'library' . DS . 'config.php');
	spl_autoload_register('__include_file');
}

function bootstrapFull() {
	echo 'Called ' . __FUNCTION__ . '<br />';
	bootstrapInit();
	pathInit();
}
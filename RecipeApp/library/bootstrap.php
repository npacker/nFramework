<?php

function __include_file($filename) {
	echo 'Called ' . __FUNCTION__ . '<br />';
	$filename = strtolower($filename);

	if (file_exists(ROOT . DS . 'library' . DS . $filename . '.class.php')) {
		require_once ROOT . DS . 'library' . DS . $filename . '.class.php';
	} else if (file_exists(ROOT . DS . 'include' . DS . $filename . '.class.php')) {
		require_once ROOT . DS . 'include' . DS . $filename . '.class.php';
	} else {
		throw new Exception("Could not load $filename.");
	}
}

function pathInit() {
	echo 'Called ' . __FUNCTION__ . '<br />';
	$uri = $_SERVER['REQUEST_URI'];
	$params = explode('/', ltrim($uri, '/'));
	$type = array_shift($params);
	$action = array_shift($params);
	$id = array_shift($params);

	try {
		route($type, $action, $id);
	} catch (BadMethodCallException $e) {
		echo $e->getMessage();
		exit();
	}
}

function route($type, $action, $id) {
	echo 'Called ' . __FUNCTION__ . '<br />';
	$controllerName = substr_replace($type, '', -1) . 'Controller';

	try {
		$controller = new $controllerName();
	} catch (Exception $e) {
		echo $e->getMessage();
		exit();
	}

	if (method_exists($controller, $action)) $controller->$action($id);
	else Throw new BadMethodCallException('Action not defined.');
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
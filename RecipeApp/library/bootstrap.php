<?php

require_once (ROOT . DS . 'library' . DS . 'config.php');

function __include_file($filename) {
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
	$name = array_shift($params);
	$action = array_shift($params);
	$id = array_shift($params);

	if (empty($name) || empty($action) || empty($id)) returnFront();
	else request($name, $action, $id);
}

function request($name, $action, $id) {

	echo 'Called ' . __FUNCTION__ . '<br />';

	$modelName = $name . 'Model';

	try {
		$model = new $modelName();
		$controller = new Controller($model, $action, $id);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}

function returnFront() {

	echo 'Called ' . __FUNCTION__ . '<br />';

	$name = 'cookbook';
	$action = 'view';
	$id = 1;
	request($name, $action, $id);
}

function bootstrapInit() {
	spl_autoload_register('__include_file');
}

function bootstrapFull() {
	bootstrapInit();
	pathInit();
}
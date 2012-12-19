<?php

require_once (ROOT . DS . 'library' . DS . 'config.php');
require_once (ROOT . DS . 'library' . DS . 'autoload.php');

function pathInit() {

	echo 'Called ' . __FUNCTION__ . '<br />';

	$uri = $_SERVER['REQUEST_URI'];
	$params = explode('/', ltrim($uri, '/'));
	$name = array_shift($params);
	$action = array_shift($params);
	$id = array_shift($params);

	if (empty($name) || empty($action) || empty($id)) returnFrontPage();
	else routeRequest($name, $action, $id);
}

function routeRequest($name, $action, $id) {

	echo 'Called ' . __FUNCTION__ . '<br />';

	$modelName = $name . 'Model';

	try {
		$model = new $modelName();
		$controller = new Controller($model, $action, $id);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}

function returnFrontPage() {

	echo 'Called ' . __FUNCTION__ . '<br />';

	$name = 'cookbook';
	$action = 'view';
	$id = 1;
	routeRequest($name, $action, $id);
}

function bootstrapFull() {
	pathInit();
}

bootstrapFull();
<?php

function pathInitialize() {
	$uri = $_SERVER['REQUEST_URI'];
	list($name, $action, $id) = explode('/', ltrim($uri, '/'));

	if (empty($name) || empty($action) || empty($id)) returnFrontPage();
	else routeRequest($name, $action, $id);
}

function routeRequest($name, $action, $id) {
	$controllerName = $name . 'Controller';
	$modelName = $name . 'Model';

	try {
		$model = new $modelName();
		$controller = new $controllerName($model, $action, $id);
	} catch (Exception $e) {
		returnFrontPage();
	}

}

function returnFrontPage() {
	$name = 'all';
	$action = 'view';
	$id = null;
	routeRequest($name, $action, $id);
}
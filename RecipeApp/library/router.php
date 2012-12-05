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
		echo $e->getMessage();
	}

}

function returnFrontPage() {
	$name = 'recipe';
	$action = 'view';
	$id = null;
	routeRequest($name, $action, $id);
}
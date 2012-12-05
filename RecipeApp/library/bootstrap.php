<?php

require_once (ROOT . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'library' . DS . 'autoload.php');

$uri = $_SERVER['REQUEST_URI'];

list($type, $action, $id) = explode('/', $uri);

if (!empty($type) && !empty($action) && !empty($id)) {
	$controllerName = $type . 'Controller';
	$modelName = $type . 'Model';

	try {
		$model = new $modelName();
	} catch (Exception $e) {
		echo $e->getMessage();
	}

	try {
		$controller = new $controllerName($model, $action, $id);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}
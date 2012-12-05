<?php

require_once (ROOT . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'library' . DS . 'autoload.php');

$uri = $_SERVER['REQUEST_URI'];
$params = explode('/', $uri);
list($type, $action, $id) = array_slice($params, 0, 3);
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
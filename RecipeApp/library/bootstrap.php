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

function exception_handler($exception) {
	echo $exception->getMessage();
	exit();
}

function bootstrapInit() {
	require_once (ROOT . DS . 'library' . DS . 'config.php');
	require_once (ROOT . DS . 'library' . DS . 'common.php');
	spl_autoload_register('__include_file');
	set_exception_handler('exception_handler');
}

function bootstrapFull() {
  bootstrapInit();
  $request = new HttpRequest(Request::server('REQUEST_URI'));
  Dispatcher::setDefaultController('Recipes');
  Dispatcher::forward($request->getController(), $request->getAction(),
    $request->getArgs());
  Dispatcher::dispatch();
}

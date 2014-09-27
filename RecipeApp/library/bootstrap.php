<?php

function __include_file($class) {
	$filename = strtolower($class);
	$libraryPath = ROOT . DS . 'library' . DS . $filename . '.class.php';
	$includesPath = ROOT . DS . 'include' . DS . $filename . '.class.php';

	if (file_exists($libraryPath)) {
		require_once $libraryPath;
	} else if (file_exists($includesPath)) {
		require $includesPath;
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
  Dispatcher::forward($request);
  Dispatcher::dispatch();
}

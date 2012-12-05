<?php

function __include_file($filename) {
	$filename = strtolower($filename);

	if (file_exists(ROOT . DS . 'library' . DS . $filename . '.class.php')) {
		require_once ROOT . DS . 'library' . DS . $filename . '.class.php';
	} else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . $filename . '.class.php')) {
		require_once DS . 'application' . DS . 'controllers' . DS . $filename . '.class.php';
	} else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . $filename . '.class.php')) {
		require_once ROOT . DS . 'application' . DS . 'models' . DS . $filename . '.class.php';
	} else {
		throw new Exception("Could not load $filename.");
	}
}

spl_autoload_register('__include_file');
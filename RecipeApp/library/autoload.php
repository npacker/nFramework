<?php

function __include_file($filename) {
	$filename = strtolower($filename);

	if (file_exists(DS . 'library' . DS . $filename . '.class.php')) {
		require_once DS . 'library' . DS . $filename . '.class.php';
	} else if (file_exists(DS . 'application' . DS . 'controllers' . DS . $filename . '.class.php')) {
		require_once DS . 'application' . DS . 'controllers' . DS . $filename . '.class.php';
	} else if (file_exists(DS . 'application' . DS . 'models' . DS . $filename . '.class.php')) {
		require_once DS . 'application' . DS . 'models' . DS . $filename . '.class.php';
	} else {
		throw new Exception("Could not load $filename.");
	}
}

spl_register_autoloader('__include_file');
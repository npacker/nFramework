<?php

function parse_path($path) {
	return array_map('strtolower', explode('/', trim($path, '/')));
}

function base_path() {
	$basepath = explode('/', rtrim(Request::server('SCRIPT_NAME'), '/'));
	array_pop($basepath);
	$basepath = implode('/', $basepath);

	return $basepath;
}
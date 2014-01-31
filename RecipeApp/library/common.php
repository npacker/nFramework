<?php

function parse_path($path) {
	return array_map('strtolower', explode('/', trim($path, '/')));
}

function base_path() {
	$filePath = Request::server('PHP_SELF');
	$documentRoot = realpath(Request::server('DOCUMENT_ROOT'));
	$basepath = str_replace($documentRoot, '', $filePath);
	$basepath = explode('/', trim($basepath, '/'));
	array_pop($basepath);
	$basepath = implode('/', $basepath);

	return $basepath;
}
<?php

function parse_path($path) {
	return array_map('strtolower', explode('/', trim($path, '/')));
}

function base_path() {
	$filePath = realpath(Request::server('PHP_SELF'));
	$documentRoot = realpath(Request::server('DOCUMENT_ROOT'));
	$basepath = str_replace($documentRoot, '', $filePath);

	return $basepath;
}
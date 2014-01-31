<?php

function parse_path($path) {
	return array_map('strtolower', explode('/', trim($path, '/')));
}

function base_path() {
	$filePath = realpath(__DIR__);
	$documentRoot = realpath(Request::server('DOCUMENT_ROOT'));
	$basepath = str_replace($documentRoot, '', $filePath);

	return $basepath;
}
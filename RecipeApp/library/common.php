<?php

define('HTTP_ERROR_NOT_FOUND', 404);

define('HTTP_ERROR_ACCESS_DENIED', 403);

define('HTTP_ERROR_SERVER_ERROR', 500);

function parse_path($path) {
	return array_map('strtolower', explode('/', trim($path, '/')));
}

function parse_query($query) {
  $query_array = array();
  
  if (!empty($query)) {
    $arguments = explode('&', $query);
      
    foreach ($arguments as $argument) {
      $parts = explode('=', $argument);
      $query_array[$parts[0]] = $parts[1];
    }
  }
  
  return $query_array;
}

function base_path() {
	$filePath = Request::server('PHP_SELF');
	$documentRoot = realpath(Request::server('DOCUMENT_ROOT'));
	$basepath = str_replace($documentRoot, '', $filePath);
	$basepath = explode('/', $basepath);
	array_pop($basepath);
	$basepath = implode('/', $basepath) . '/';

	return $basepath;
}
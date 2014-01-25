<?php

function parse_path($path) {
	return array_map('strtolower', explode('/', trim($path, '/')));
}

function base_path() {
	$basepath = parse_path(Reqeust::server('SCRIPT_NAME'));
	array_pop($basepath);

	return $basepath;
}
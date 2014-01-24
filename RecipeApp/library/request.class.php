<?php

class Request {

	final private function __construct() {}

	final private function __clone() {}

	public static function get($key, $default=null) {
		$value = $default;
		if (array_key_exists($key, $_GET)) $value = $_GET[$key];
		return $value;
	}

	public static function post($key, $default=null) {
		$value = $default;
		if (array_key_exists($key, $_POST)) $value = $_POST[$key];
		return $value;
	}

	public static function server($key, $default=null) {
		$value = $default;
		if (array_key_exists($key, $_SERVER)) $value = $_SERVER[$key];
		return $value;
	}

}
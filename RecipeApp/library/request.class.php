<?php

class Request {

	final private function __construct() {}

	final private function __clone() {}

	public static function get($key, $default=null) {
		echo 'Called ' . __METHOD__ . "<br />";
		$value = $default;
		if (array_key_exists($key, $_GET)) $value = $_GET[$key];
		return $value;
	}

	public static function post($key, $default=null) {
		echo 'Called ' . __METHOD__ . "<br />";
		$value = $default;
		if (array_key_exists($key, $_POST)) $value = $_POST[$key];
		return $value;
	}

	public static function server($key, $default=null) {
		echo 'Called ' . __METHOD__ . "<br />";
		$value = $default;
		echo $_SERVER[$key];
		if (!empty($_SERVER[$key])) $value = $_SERVER[$key];
		return $value;
	}

}
<?php

abstract class Base {

	public function __get($property) {
		$method = 'get' . ucfirst($property);

		return $this->$method();
	}

	public function __call($method, $arguments) {
		if (preg_match('/^(get)([A-Z])(.*)$/', $method, $matches)) {
			$property = strtolower($matches[2]) . $matches[3];

			try {
				$value = $this->get($property);
			} catch (Exception $e) {
				echo $e;
			}

			return $value;
		}
	}

	protected function get($property) {
		if (property_exists($this, $property)) $value = $this->$property;
		else throw new Exception("Property {$property} not defined.");

		return $value;
	}

	protected function invalidArgumentExceptionMessage($method, &$argument, $argNum, $expected) {
		$template = "Argument %s passed to %s must be a %s, %s given.";
		$given = gettype($argument);
		$message = sprintf($template, $argNum, $method, $expected, $given);

		return $message;
	}

}
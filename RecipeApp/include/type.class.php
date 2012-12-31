<?php

abstract class Type {

	public function __call($method, $arguments) {
		if (preg_match('/^(get)([A-Z])(.*)$/', $method, $matches)) {
			$property = strtolower($matches[2]) . $matches[3];

			return $this->get($property);
		}
	}

	public function getProperites() {
		return get_object_vars($this);
	}

	final protected function get($property) {
		return $this->$property;
	}

}
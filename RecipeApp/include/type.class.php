<?php

abstract class Type {

	public function __get($property) {
		echo 'Called ' . __METHOD__ . "<br />";
		$method = 'get' . ucfirst($property);

		return $this->$method();
	}

	public function __call($method, $arguments) {
		echo 'Called ' . __METHOD__ . "<br />";
		if (preg_match('/^(get)([A-Z])(.*)$/', $method, $matches)) {
			$property = strtolower($matches[2]) . $matches[3];

			return $this->get($property);
		}
	}

	public function getProperites() {
		echo 'Called ' . __METHOD__ . "<br />";
		return get_object_vars($this);
	}

	protected function get($property) {
		echo 'Called ' . __METHOD__ . "<br />";
		return $this->$property;
	}

}
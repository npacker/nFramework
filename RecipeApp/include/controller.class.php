<?php

abstract class Controller {

	protected $model;
	protected $view;

	public function __construct() {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->view = new View();
	}

	public function __destruct() {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->view->render();
	}

	protected function prepare(Type $type) {
		echo 'Called ' . __METHOD__ . "<br />";
		$vars = $type->getProperites();

		foreach ($vars as $key => $value) {
			$this->set($key, $value);
		}
	}

	protected function set($key, $value) {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->view->set($key, $value);
	}

	protected function validateId($id) {
		if (!is_numeric($id) && !is_null($id)) throw new InvalidArgumentException("$id is not numeric.");
	}

}
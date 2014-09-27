<?php

abstract class Controller {

	protected $model;
	protected $view;

	public function __construct() {
		$this->view = new View();
	}

	public function __destruct() {
		$this->view->render();
	}

	protected function prepare(Entity $entity) {
		$vars = $entity->getProperites();

		foreach ($vars as $key => $value) {
			$this->set($key, $value);
		}
	}

	protected function set($key, $value) {
		$this->view->set($key, $value);
	}

	protected function validateId($id) {
		if (!is_numeric($id) && !is_null($id)) throw new InvalidArgumentException("$id is not numeric.");
	}

}
<?php

abstract class Controller {

	protected $model;
	protected $view;

	public function __destruct() {
		$this->view->render();
	}

	protected function prepare(Entity $entity) {
		$properties = $entity->getProperites();

		foreach ($properties as $key => $value) {
			$this->set($key, $value);
		}
	}

	protected function set($key, $value) {
		$this->view->set($key, $value);
	}

}
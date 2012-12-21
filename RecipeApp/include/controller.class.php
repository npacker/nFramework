<?php

class Controller {

	protected $view;

	public function __construct(Model $model, $action, $id) {

		echo 'Called ' . __METHOD__ . "<br />";

		// This is a temporary implementation of the view layer.
		$this->view = new View();

		switch ($action) {
			case 'delete':
				$this->prepare($model->delete($id));
				break;
			case 'update':
				if (!empty($_POST)) $this->prepare($model->update($id, $_POST));
				break;
			case 'create':
				if (!empty($_POST)) $this->prepare($model->create($_POST));
				break;
			case 'view':
				if (isset($id)) $this->prepare($model->get($id));
				else $this->prepare($model->all());
				break;
			default:
				Throw new Exception('The requested action is undefined.');
				break;
		}
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

}
<?php

class Controller {

	protected $model;
	protected $action;
	protected $id;
	protected $template;

	public function __construct(Model $model, $action, $id=null) {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->model = $model;
		$this->action = $action;
		$this->id = $id;
		$this->template = new Template();

		if (isset($id)) $this->getProperties($this->model->$action($id));
		else $this->getProperties($this->model->$action());
	}

	public function __destruct() {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->template->render();
	}

	protected function getProperties($object) {

		echo 'Called ' . __METHOD__ . "<br />";

		$vars = get_object_vars($object);

		foreach ($vars as $key => $value) {
			$this->set($key, $value);
			echo $key;
		}
	}

	protected function set($key, $value) {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->template->set($key, $value);
	}

}
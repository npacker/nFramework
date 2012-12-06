<?php

class Controller {

	protected $model;
	protected $action;
	protected $id;
	protected $template;

	public function __construct(Model $model, $action, $id=null) {

		echo 'Controller constructor.';

		$this->model = $model;
		$this->action = $action;

		if (isset($id)) {
			if (is_int($id)) $this->id = $id;
			else throw new InvalidArgumentException();
		}

		$this->template = new Template();

		if (isset($id)) $this->getProperties($this->model->$action($id));
		else $this->getProperties($this->model->$action());
	}

	public function __destruct() {
		$this->template->render();
	}

	protected function getProperties(Object $object) {
		$vars = get_object_vars($object);

		foreach ($vars as $key => $value) {
			$this->set($key, $value);
		}
	}

	protected function set($key, $value) {
		$this->template->set($key, $value);
	}

}
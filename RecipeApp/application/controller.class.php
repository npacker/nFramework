<?php

class Controller {

	protected $model;
	protected $action;
	protected $id;
	protected $template;

	public function __construct(Model $model, $action, $id=null) {
		$this->model = $model;
		$this->action = $action;
		$this->id = $id;
		$this->template = new Template();
		if (isset($id)) $this->getProperties($this->model->$action($id));
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
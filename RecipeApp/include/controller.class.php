<?php

class Controller {

	protected $model;
	protected $template;

	public function __construct(Model $model, $action, $id=null) {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->model = $model;
		$this->template = new Template();
		if (isset($id))	$this->setTemplateVars($this->model->$action($id));
		else $this->setTemplateVars($this->model->$action());
	}

	public function __destruct() {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->template->render();
	}

	protected function setTemplateVars($node) {

		if (!is_object($node)) return;

		echo 'Called ' . __METHOD__ . "<br />";

		$vars = $node->getProperites();

		foreach ($vars as $key => $value) {
			$this->set($key, $value);
		}
	}

	protected function set($key, $value) {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->template->set($key, $value);
	}

}
<?php

class Controller {

	protected $model;
	protected $template;

	public function __construct(Model $model, $action, $id) {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->model = $model;
		$this->template = new Template();
		try {
			$this->setTemplateVars($this->model->$action($id));
		} Catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function __destruct() {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->template->render();
	}

	protected function setTemplateVars(Node $node) {

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
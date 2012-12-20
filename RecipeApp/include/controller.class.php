<?php

class Controller {

	protected $template;

	public function __construct(Model $model, $action, $id) {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->template = new Template();

		switch ($action) {
			case 'view':
				if (isset($id)) $this->setTemplateVars($model->view($id));
				else $this->setTemplateVars($model->viewAll());
				break;
			case 'create':
				if (isset($_POST)) $this->setTemplateVars($model->create($_POST));
				break;
			case 'update':
				if (isset($_POST)) $this->setTemplateVars($model->update($id, $_POST));
				break;
			case 'delete':
				$this->setTemplateVars($model->delete($id));
				break;
			default:
				Throw new Exception('Error.');
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
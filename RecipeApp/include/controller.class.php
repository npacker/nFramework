<?php

class Controller {

	protected $template;

	public function __construct(Model $model, $action, $id) {

		echo 'Called ' . __METHOD__ . "<br />";

		$this->template = new Template();

		switch ($action) {
			case 'delete':
				$this->setTemplateVars($model->delete($id));
				break;
			case 'update':
				if (!empty($_POST)) $this->setTemplateVars($model->update($id, $_POST));
				break;
			case 'create':
				if (!empty($_POST)) $this->setTemplateVars($model->create($_POST));
				break;
			case 'view':
				if (isset($id)) $this->setTemplateVars($model->view($id));
				else $this->setTemplateVars($model->all());
				break;
			default:
				Throw new Exception('The requested action is undefined.');
				break;
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
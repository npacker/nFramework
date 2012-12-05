<?php

class RecipeController extends Controller {

	public function __construct($model, $action, $id) {
		parent::__construct($model, $action, $id);

		if (isset($id)) $this->model->$action($id);
		else $this->model->viewAll();
	}

}
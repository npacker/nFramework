<?php

class IngredientController extends Controller {

	public function __construct($model, $action, $id) {
		parent::__construct($model, $action, $id);

		$this->getProperties($this->model->$action($id));
	}

}
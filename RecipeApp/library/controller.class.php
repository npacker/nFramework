<?php

abstract class Controller {

	protected $model;
	protected $action;
	protected $id;

	public function __construct(Model $model, $action, $id) {
		$this->model = $model;
		$this->action = $action;
		$this->id = $id;
	}

}
<?php

abstract class Controller {

	protected $_model;
	protected $_action;

	public function __construct($model, $action) {
		$this->_model = $model;
		$this->_action = $action;
	}

	public function __destruct() {

	}

}
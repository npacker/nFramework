<?php

class HttpErrorController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->model = new HttpErrorModel();
	}

	public function index(array $args) {
		$this->prepare($this->model->find($args['error_code'], $args['error_message']));
	}

}
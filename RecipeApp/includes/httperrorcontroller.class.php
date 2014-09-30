<?php

class HttpErrorController extends Controller {

  public function __construct() {
    $this->model = new HttpErrorModel();
  }

  public function view(array $args) {
    $this->setTemplate('view');
    $this->prepare($this->model->find($args['error_code'], $args['error_message'], $args['request_uri']));
    $this->render();
  }

}
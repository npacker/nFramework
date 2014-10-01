<?php

class HttpErrorController extends Controller {

  public function __construct() {
    $this->model = new HttpErrorModel();
  }

  public function view(array $args) {
    $httpError = $this->model->find($args['error_code'], $args['request_uri'], $args['error_message']);

    $data = array();

    $data['page_title'] = $httpError->getTitle();
    $data['page'] = new Template('httperror/view', $httpError);

    return $data;
  }

}
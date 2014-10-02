<?php

class HttpErrorController extends Controller {

  public function __construct() {
    $this->model = new HttpErrorModel();
  }

  public function view(array $args = array()) {
    $httpError = $this->model->find($args['code'], $args['uri'], $args['message']);

    $data['page_title'] = $httpError->getTitle();
    $data['page'] = new Template('httperror/view', $httpError);

    return $data;
  }

}
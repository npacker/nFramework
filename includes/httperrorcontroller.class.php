<?php

class HttpErrorController extends Controller {

  public function __construct() {
    $this->model = new HttpErrorModel();
  }

  public function view(array $args = array()) {
    $httpError = $this->model->find($args['code'], $args['uri'], $args['message']);

    $data['title'] = $httpError->getTitle();
    $data['content'] = new Template('httperror/view', $httpError);
    $data['template'] = 'html';

    return $data;
  }

}
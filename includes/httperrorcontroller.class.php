<?php

class HttpErrorController extends Controller {

  public function __construct() {
    $this->model = new HttpErrorModel();
  }

  public function view(array $args = array()) {
    if ($args['uri'] == '/') {
      $defaults = new DefaultController();
      return $defaults->view();
    }

    $httpError = $this->model->find($args['code'], $args['uri'], $args['message']);

    $data['title'] = $httpError->getTitle();
    $data['content'] = new Template('httperror/view', $httpError);
    $data['template'] = 'html';

    return $data;
  }

}

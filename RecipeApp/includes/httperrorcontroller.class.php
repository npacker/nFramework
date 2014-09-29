<?php

class HttpErrorController extends Controller {

  public function __construct() {
    $this->model = new HttpErrorModel();
  }

  /**
   * The appropriate view for the given action is set here, and prepared for rendering. 
   */
  public function view(array $args) {
    $this->view = new HttpErrorView();
    $this->prepare($this->model->find($args['error_code'], $args['error_message']));
  }

}
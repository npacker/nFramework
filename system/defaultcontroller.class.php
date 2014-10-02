<?php

class DefaultController extends Controller {
  public function view() {
     $data = array();

    $data['title'] = 'Welcome';
    $data['content'] = new Template('default/page');
    $data['template'] = 'html';

    return $data;
  }
}

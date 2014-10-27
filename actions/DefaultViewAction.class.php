<?php

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;

class DefaultViewAction extends Action {

  public function execute(Context $context) {
    $data = array();

    $data['title'] = 'Welcome';
    $data['content'] = new Template('default/page');
    $data['template'] = 'html';

    return $data;
  }

}
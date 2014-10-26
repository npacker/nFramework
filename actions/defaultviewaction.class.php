<?php

use nFramework\Application\Action;
use nFramework\Application\ActionContext;
use nFramework\Application\View\Template;

class DefaultViewAction extends Action {

  public function execute(ActionContext $context) {
    $data = array();

    $data['title'] = 'Welcome';
    $data['content'] = new Template('default/page');
    $data['template'] = 'html';

    return $data;
  }

}
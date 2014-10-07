<?php

class DefaultViewAction extends Action implements iAction {

  public function execute(ActionContext $context) {
    $data = array();

    $data['title'] = 'Welcome';
    $data['content'] = new Template('default/page');
    $data['template'] = 'html';

    return $data;
  }

}
<?php

use nFramework\Action;
use nFramework\ActionContext;
use nFramework\View\Template;

class LogoutAction extends Action {

  public function execute(ActionContext $context) {
    $session = new Session();
    $session->destroy();

    return array('location' => 'http://' . base_url() . base_path() . '/');
  }

}
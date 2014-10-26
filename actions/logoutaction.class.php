<?php

use nFramework\Application\Action;
use nFramework\Application\ActionContext;
use nFramework\Application\View\Template;

class LogoutAction extends Action {

  public function execute(ActionContext $context) {
    $session = new Session();
    $session->destroy();

    return array('location' => 'http://' . base_url() . base_path() . '/');
  }

}
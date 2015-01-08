<?php

namespace Nigel\WebsitePackage;

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Response;
use nFramework\Service\Session;

class LogoutAction extends Action {

  public function execute(Context $context) {
    $session = new Session();
    $session->destroy();
    $response = new Response();

    return $response->redirect(url());
  }

}

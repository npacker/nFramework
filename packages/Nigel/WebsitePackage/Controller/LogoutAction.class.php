<?php

namespace Nigel\WebsitePackage;

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Response;
use nFramework\Service\Session;

class LogoutAction extends Action {

  private $session;

  public function __construct(Session $session) {
    $this->session = $session;
  }

  public function execute(Context $context) {
    $this->session->destroy();
    $response = new Response();

    return $response->redirect(url());
  }

}

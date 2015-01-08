<?php

namespace Nigel\WebsitePackage;

use nFramework\Exception\AccessDeniedException;
use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Response;
use nFramework\Service\Session;

class LoginAction extends Action {

  public function execute(Context $context) {
    $session = new Session();
    $response = new Response();
    $session->start();

    if ($session->valid()) {
      return $response->redirect(url());
    }

    $username = $context->get('username');
    $password = $context->get('password');

    if (isset($username) && isset($password)) {
      $mapper = new UserMapper();
      $user = new User();
      $user->setUsername($username);
      $mapper->find($user);

      if (hash('sha256', $password) == $user->getPassword()) {
        $session->validate($context);

        return $response->redirect(url());
      }

      throw new AccessDeniedException('Incorrect username or password');
    }

    $template = new Template('Nigel:WebsitePackage:html', array(
      'title' => 'Login',
      'page' => new Template('Nigel:WebsitePackage:login:login', array(
        'action' => url('login')
      ))
    ));
    $template->addStyle('Nigel:WebsitePackage:default');
    $template->addScript('Nigel:WebsitePackage:default');

    return $response->content($template->render());
  }

}

<?php

namespace Nigel\WebsitePackage;

use nFramework\Exception\AccessDeniedException;
use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Response;
use nFramework\Service\Session;

class LoginAction extends Action {

  private $session;

  private $user;

  private $userMapper;

  public function __construct(Session $session, User $user, UserMapper $userMapper) {
    $this->session = $session;
    $this->user = $user;
    $this->userMapper = $userMapper;
  }

  public function execute(Context $context) {
    $response = new Response();
    $this->session->start();

    if ($this->session->valid()) {
      return $response->redirect(url());
    }

    $username = $context->get('username');
    $password = $context->get('password');

    if (isset($username) && isset($password)) {
      $this->user->setUsername($username);
      $this->userMapper->find($this->user);

      if (hash('sha256', $password) == $this->user->getPassword()) {
        $this->session->validate($context);

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

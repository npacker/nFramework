<?php

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Exception\AccessDeniedException;
use nFramework\Response;

class LoginAction extends Action {

  public function execute(Context $context) {
    $session = new Session();
    $session->start();

    if ($session->valid()) {
      return array('location' => 'http://' . base_url() . base_path() . '/');
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

        return array('location' => 'http://' . base_url() . base_path() . '/');
      }

      throw new AccessDeniedException('Incorrect username or password');
    }

    $template = new Template('html', array(
      'title' => 'Login',
      'header' => new Template('header', array('base_url' => base_url(), 'base_path' => base_path())),
      'page' => new Template('login/login', array('action' => 'http://' . base_url() . base_path() . '/login')),
      'footer' => new Template('footer')
    ));
    $template->addStyle('default');
    $template->addScript('default');

    return new Response($template->parse());
  }

}

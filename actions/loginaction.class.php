<?php

class LoginAction extends Action {

  public function execute(ActionContext $context) {
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

    $action = 'http://' . base_url() . base_path() . '/login';

    $data = array(
      'title' => 'Login',
      'content' => new Template('login/login', array('action' => $action)),
      'template' => 'html');

    return $data;
  }

}
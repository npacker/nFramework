<?php

class LoginAction extends Action {

  public function execute(ActionContext $context) {
    $username = $context->get('username');
    $password = $context->get('password');

    if (isset($username) && isset($password)) {
      $user = new User();
      $user->setUsername($username);
      $mapper = new UserMapper();
      $mapper->find($user);

      if (hash('sha256', $password) == $user->getPassword()) {
        $session = new Session();
        $session->start();
        $session->validate();

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
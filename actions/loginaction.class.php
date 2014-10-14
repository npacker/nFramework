<?php

class LoginAction extends Action implements iAction {

  public function execute(ActionContext $context) {
    $username = $context->get('username');
    $password = $context->get('password');

    if (isset($username) && isset($password)) {
      $userMapper = new User();
      $user = $userMapper->find($username);

      if (hash('sha256', $password) == $user['password']) {
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
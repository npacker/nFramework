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

    $variables['action'] = 'http://' . base_url() . base_path() . '/login';

    $data['title'] = 'Login';
    $data['content'] = new Template('login/login', $variables);
    $data['template'] = 'html';

    return $data;
  }

}

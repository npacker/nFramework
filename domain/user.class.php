<?php

class User extends DomainObject {

  public $id;

  public $password;

  public $username;

  public function __construct(array $data = array()) {
    if (isset($data['id'])) {
      $this->setId($data['id']);
    }

    if (isset($data['password'])) {
      $this->setPassword($data['password']);
    }

    if (isset($data['username'])) {
      $this->setUsername($data['username']);
    }
  }

  public function getId() {
    return $this->id;
  }

  public function getPassword() {
    return $this->password;
  }

  public function getUsername() {
    return $this->username;
  }

  public function setId($id) {
    if (!$id) {
      throw new InvalidInputException('User id is required.');
    } else if (!is_numeric($id)) {
      throw new InvalidInputException('User id must be numeric');
    }

    $this->id = $id;
  }

  public function setPassword($password) {
    if (!$password) {
      throw new InvalidInputException('User password is required.');
    } else if (strlen($passwored) != 64) {
      throw new InvalidInputException('User password is in an invalid format');
    }

    $this->password = $password;
  }

  public function setUsername($username) {
    if (!$username) {
      throw new InvalidInputException('Username is required.');
    } else if (!preg_match("/[A-Za-z0-9]/", $username)) {
      throw new InvalidInputException('Username is in an invalid format.');
    }

    $this->username = $username;
  }

}
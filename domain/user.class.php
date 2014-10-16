<?php

class User extends DomainObject {

  public $id;

  public $password;

  public $username;

  public function __construct(array $data = array()) {
    if (isset($data['id'])) {
      $this->id = $data['id'];
    }

    if (isset($data['password'])) {
      $this->password = $data['password'];
    }

    if (isset($data['username'])) {
      $this->username = $data['username'];
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
    if (empty($id)) {
      throw new InvalidInputException('User id is required.');
    } else if (!is_numeric($id)) {
      throw new InvalidInputException('User id must be numeric');
    }

    $this->id = $id;
  }

  public function setUsername($username) {
    if (empty($username)) {
      throw new InvalidInputException('Username is required.');
    } else if (!preg_match("/[A-Za-z0-9]/", $username)) {
      throw new InvalidInputException('Username is in an invalid format.');
    }

    $this->username = $username;
  }

}
<?php

use nFramework\Application\Model\DataMapper;
use nFramework\Application\Model\DomainObject;

class UserMapper extends DataMapper {

  public function find(DomainObject $user) {
    $id = $user->getId();
    $username = $user->getUsername();

    $sql = 'SELECT id, username, password
            FROM user';

    if ($id) {
      $sql .= ' WHERE id = ?';
      $parameters = array($id);
    } else if ($username) {
      $sql .= ' WHERE username = ?';
      $parameters = array($username);
    }

    $this->database->connect();
    $this->database->query($sql)
      ->execute($parameters, PDO::FETCH_INTO, $user)
      ->fetch();
    $this->database->close();
  }

  public function findAll() {

  }

  public function create(DomainObject $object) {

  }

  public function delete(DomainObject $object) {

  }

  public function update(DomainObject $object) {

  }

}
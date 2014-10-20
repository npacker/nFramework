<?php

class UserMapper extends DataMapper {

  public function find(DomainObject $user) {
    $id = $user->getId();
    $username = $user->getUsername();

    $sql = 'SELECT id, username, password
            FROM user';

    if (!empty($id)) {
      $sql .= ' WHERE id = ?';
    } else if (!empty($username)) {
      $sql .= ' WHERE username = ?';
    }

    $this->database->connect();
    $this->database->query($sql)
      ->execute(array($id), PDO::FETCH_INTO, $user)
      ->fetch();
    $this->database->close();
  }

}
<?php

class UserMapper extends DataMapper {

  public function find($id) {
    $sql = 'SELECT id, username, password
            FROM user';

    if (is_numeric($id)) {
      $sql .= ' WHERE id = ?';
    } else {
      $sql .= ' WHERE username = ?';
    }

    $this->database->connect();
    $result = $this->database->query($sql)
      ->execute(array($id))
      ->fetch();
    $this->database->close();

    return $result;
  }

}
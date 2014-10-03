<?php

class PageModel extends Model {

  public function find($id) {
    $sql = 'SELECT id, title, content, created
            FROM pages
            WHERE id = ?';

    $this->database->connect();
    $result = $this->database->query($sql)
      ->execute(array($id))
      ->fetch();
    $this->database->close();

    return $result;
  }

  public function all() {
    $sql = 'SELECT id, title, content, created
            FROM pages';

    $this->database->connect();
    $result = $this->database->query($sql)
      ->execute()
      ->fetchAll();
    $this->database->close();

    return $result;
  }

  public function save($id, $title, $content) {

  }

}
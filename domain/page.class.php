<?php

class Page extends DataMapper {

  public function all() {
    $sql = 'SELECT id, title, content, created
            FROM page';

    $this->database->connect();
    $result = $this->database->query($sql)
      ->execute()
      ->fetchAll();
    $this->database->close();

    return $result;
  }

  public function create($title, $content) {
    $sql = 'INSERT INTO page
              (title, content)
            VALUES
              (?, ?)';

    $this->database->connect();
    $query = $this->database->query($sql);
    $query->execute(array($title, $content));
    $this->database->close();

    return $query->lastInsertId();
  }

  public function delete($id) {
    $sql = 'DELETE FROM page
            WHERE id = ?';

    $this->database->connect();
    $this->database->query($sql)
      ->execute(array($id));
    $this->database->close();
  }

  public function find($id) {
    $sql = 'SELECT id, title, content, created
            FROM page
            WHERE id = ?';

    $this->database->connect();
    $result = $this->database->query($sql)
    ->execute(array($id))
    ->fetch();
    $this->database->close();

    return $result;
  }

  public function update($id, $title, $content) {
    $sql = 'UPDATE page
            SET title = ?, content = ?
            WHERE id = ?';

    $this->database->connect();
    $this->database->query($sql)
      ->execute(array($title,$content,$id));
    $this->database->close();
  }

}
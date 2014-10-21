<?php

class PageMapper extends DataMapper {

  public function create(DomainObject $page) {
    $title = $page->getTitle();
    $content = $page->getContent();

    $sql = 'INSERT INTO page
              (title, content)
            VALUES
              (?, ?)';

    $this->database->connect();
    $query = $this->database->query($sql);
    $query->execute(array($title, $content));
    $this->database->close();

    $page->setId($query->lastInsertId());
  }

  public function delete(DomainObject $page) {
    $id = $page->getId();

    $sql = 'DELETE FROM page
            WHERE id = ?';

    $this->database->connect();
    $this->database->query($sql)
      ->execute(array($id));
    $this->database->close();
  }

  public function find(DomainObject $page) {
    $id = $page->getId();

    $sql = 'SELECT id, title, content, created
            FROM page
            WHERE id = ?';

    $this->database->connect();
    $result = $this->database->query($sql)
      ->execute(array($id), PDO::FETCH_INTO, $page)
      ->fetch();
    $this->database->close();

    $title = $page->getTitle();

    if (empty($title)) {
      throw new ResourceNotFoundException('The page could not be found.');
    }
  }

  public function findAll() {
    $sql = 'SELECT id, title, content, created
            FROM page';

    $this->database->connect();
    $result = $this->database->query($sql)
      ->execute()
      ->fetchAll();
    $this->database->close();

    return new DomainObjectCollection($result, new PageFactory());
  }

  public function update(DomainObject $page) {
    $id = $page->getId();
    $title = $page->getTitle();
    $content = $page->getContent();

    $sql = 'UPDATE page
            SET title = ?, content = ?
            WHERE id = ?';

    $this->database->connect();
    $this->database->query($sql)
      ->execute(array($title, $content, $id));
    $this->database->close();
  }

}

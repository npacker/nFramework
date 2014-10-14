<?php

class Ingredient extends DataMapper {

  public function find($id) {
    $sql = "SELECT id, title, quantity
            FROM ingredient
            WHERE id = ?";

    $this->database->connect();
    $result = $this->database->query($sql)
      ->execute(array($id))
      ->fetch();
    $this->database->close();

    return $result;
  }

  public function recipe($recipe_id) {
    $sql = "SELECT title, quantity
            FROM ingredient
            WHERE recipe_id = ?";

    $this->database->connect();
    $result = $this->database->query($sql)
      ->execute(array($recipe_id))
      ->fetchAll();
    $this->database->close();

    return $result;
  }

  public function all() {
    $sql = "SELECT id, title, quantity
            FROM ingredient";

    $this->database->connect();
    $result = $this->database->query($sql)
      ->execute()
      ->fetchAll();
    $this->database->close();

    return $result;
  }

}
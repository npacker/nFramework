<?php

class Recipe extends DataMapper {

  public function find($id) {
    $sql = 'SELECT title
            FROM recipes
            WHERE id = ?';

    $this->database->connect();
    $result = $this->database->query($sql)
      ->execute(array($id))
      ->fetch();
    $this->database->close();

    return $result;
  }

  public function all() {
    $sql = "SELECT recipes.id, recipes.title AS title, GROUP_CONCAT(ingredients.title SEPARATOR ', ') AS ingredients
            FROM recipes LEFT JOIN ingredients
            ON recipes.id = ingredients.recipe_id
            GROUP BY recipes.title";

    $this->database->connect();
    $result = $this->database->query($sql)
      ->execute()
      ->fetchAll();
    $this->database->close();

    return $result;
  }

}
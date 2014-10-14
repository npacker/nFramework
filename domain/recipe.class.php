<?php

class Recipe extends DataMapper {

  public function find($id) {
    $sql = 'SELECT title
            FROM recipe
            WHERE id = ?';

    $this->database->connect();
    $result = $this->database->query($sql)
      ->execute(array($id))
      ->fetch();
    $this->database->close();

    return $result;
  }

  public function all() {
    $sql = "SELECT recipe.id, recipe.title AS title, GROUP_CONCAT(ingredient.title SEPARATOR ', ') AS ingredients
            FROM recipe LEFT JOIN ingredient
            ON recipe.id = ingredient.recipe_id
            GROUP BY recipe.title";

    $this->database->connect();
    $result = $this->database->query($sql)
      ->execute()
      ->fetchAll();
    $this->database->close();

    return $result;
  }

}
<?php

class RecipeModel extends Model {

	public function find($id) {
	  $this->database->connect();
	  $result = $this->database->query('SELECT title FROM recipes WHERE id = ?')
	             ->execute(array($id))
	             ->fetch();
	  $this->database->close();

		return $result;
	}

	public function all() {
    $this->database->connect();
    $result = $this->database->query('SELECT id, title FROM recipes')
                ->execute()
                ->fetchAll();
    $this->database->close();

    return $result;
	}

}
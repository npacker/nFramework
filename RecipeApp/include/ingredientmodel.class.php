<?php

class IngredientModel extends Model {

	public function __construct() {
		echo 'Called ' . __METHOD__ . "<br />";
		parent::__construct();
	}

	public function get($id) {
		echo 'Called ' . __METHOD__ . "<br />";
		$query = 'SELECT name, quantity FROM ingredients WHERE id = :id';
		$statement = $this->connection->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->setFetchMode(PDO::FETCH_CLASS, 'Ingredient');

		try {
			$statement->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
			exit();
		}

  	$ingredient = $statement->fetch();
  	$statement->closeCursor();

		return $ingredient;
	}

	public function join($id, $field) {
		echo 'Called ' . __METHOD__ . "<br />";
		$query = "SELECT name, quantity FROM ingredients WHERE $field = :$field";
		$statement = $this->connection->prepare($query);
		$statement->bindParam(":$field", $id);
		$statement->setFetchMode(PDO::FETCH_CLASS, 'Ingredient');

		try {
			$statement->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
			exit();
		}

		$ingredients = array();

		foreach ($statement as $ingredient) {
			array_push($ingredients, $ingredient);
		}

		$statement->closeCursor();

		return $ingredients;
	}

	public function all() {}

	public function create(Array $data) {}

	public function update($id, Array $data) {}

	public function delete($id) {
		echo 'Called ' . __METHOD__ . "<br />";
		$query = 'DELETE FROM ingredients WHERE id = :id';
		$statement = $this->connection->prepare($query);
		$satement->bindParam(':id', $id);

		try {
			$statement->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
			exit();
		}
	}

}
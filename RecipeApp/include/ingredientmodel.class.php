<?php

class IngredientModel extends Model {

	public function __construct() {
		echo 'Called ' . __METHOD__ . "<br />";
		parent::__construct();
	}

	public function find($id) {
		echo 'Called ' . __METHOD__ . "<br />";
		$query = 'SELECT name, quantity FROM ingredients WHERE id = :id';

		try {
			$statement = $this->connection->prepare($query);
			$statement->bindParam(':id', $id);
			$statement->setFetchMode(PDO::FETCH_CLASS, 'Ingredient');
			$statement->execute();
			$ingredient = $statement->fetch();
			$statement->closeCursor();
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}

		return $ingredient;
	}

	public function join($id, $field) {
		echo 'Called ' . __METHOD__ . "<br />";
		$query = "SELECT name, quantity FROM ingredients WHERE $field = :$field";

		try {
			$statement = $this->connection->prepare($query);
			$statement->bindParam(":$field", $id);
			$statement->setFetchMode(PDO::FETCH_CLASS, 'Ingredient');
			$statement->execute();
			$ingredients = array();

			foreach ($statement as $ingredient) {
				array_push($ingredients, $ingredient);
			}

			$statement->closeCursor();
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}

		return $ingredients;
	}

	public function all() {}

	public function create() {}

	public function update($id) {}

	public function delete($id) {
		echo 'Called ' . __METHOD__ . "<br />";
		$query = 'DELETE FROM ingredients WHERE id = :id';

		try {
			$statement = $this->connection->prepare($query);
			$satement->bindParam(':id', $id);
			$statement->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}
	}

}
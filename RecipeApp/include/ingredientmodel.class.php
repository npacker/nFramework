<?php

class IngredientModel extends Model {

	public function __construct() {

		echo 'Called ' . __METHOD__ . "<br />";

		parent::__construct();
	}

	public function view($id) {

		echo 'Called ' . __METHOD__ . "<br />";

		$query = 'SELECT name, quantity FROM ingredients WHERE id = :id';
		$statement = $this->connection->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->setFetchMode(PDO::FETCH_CLASS, 'Ingredient');
		$statement->execute();
  	$ingredient = $statement->fetch();

		return $ingredient;
	}

	public function viewSet($recipeId) {

		echo 'Called ' . __METHOD__ . "<br />";

		$query = 'SELECT name, quantity FROM ingredients WHERE recipe_id = :recipe_id';
		$statement = $this->connection->prepare($query);
		$statement->bindParam(':recipe_id', $recipeId);
		$statement->setFetchMode(PDO::FETCH_CLASS, 'Ingredient');
		$statement->execute();
		$ingredients = array();

		foreach ($statement as $ingredient) {
			array_push($ingredients, $ingredient);
		}

		return $ingredients;
	}

	public function viewAll() {

		echo 'Called ' . __METHOD__ . "<br />";

		$query = 'SELECT name, quantity FROM ingredients';
		$statement = $this->connection->prepare($query);
		$statement->setFetchMode(PDO::FETCH_CLASS, 'Ingredient');
		$statement->execute();
		$ingredients = array();

		foreach ($statement as $ingredient) {
			array_push($ingredients, $ingredient);
		}

		return $ingredients;
	}

	public function create() {}

	public function update($id) {}

	public function delete($id) {}

}
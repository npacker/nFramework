<?php

class IngredientModel extends Model {

	public function view($id) {
		$query = 'SELECT name, quantity FROM ingredients WHERE id = :id';
		$statement = $this->connection->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
  	$ingredient = $statement->fetch(PDO::FETCH_CLASS, 'Ingredient');

		return $ingredient;
	}

	public function viewSet($recipeId) {
		$query = 'SELECT name, quantity FROM ingredients WHERE recipe_id = :recipe_id';
		$statement = $this->connection->prepare($query);
		$statement->bindParam(':recipe_id', $recipeId);
		$statement->setFetchMode(PDO::FETCH_CLASS, 'Ingredient');
		$statement->execute();
		$ingredients = array();

		foreach ($statement as $row) {
			array_push($ingredients, $row);
		}

		return $ingredients;
	}

	public function viewAll() {
		$query = 'SELECT name, quantity FROM ingredients';
		$statement = $this->connection->prepare($query);
		$statement->setFetchMode(PDO::FETCH_CLASS, 'Ingredient');
		$statement->execute();
		$ingredients = array();

		foreach ($statement as $row) {
			array_push($ingredients, $row);
		}

		return $ingredients;
	}

	public function edit($id) {}

	public function create($id) {}

	public function update($id) {}

	public function delete($id) {}

}
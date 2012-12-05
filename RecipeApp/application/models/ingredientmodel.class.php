<?php

class IngredientModel extends Model {

	public function view($id) {
		$query = 'SELECT name, quantity FROM ingredients WHERE id = :id';
		$statement = $this->connection->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->execute();
  	$result = $statement->fetch(PDO::FETCH_CLASS, 'Ingredient');

		return $result;
	}

	public function viewAll($recipeId) {
		$query = 'SELECT name, quantity FROM ingredients WHERE recipe_id = :recipe_id';
		$statement = $this->connection->prepare($query);
		$statement->bindParam(':recipe_id', $recipeId);
		$statement->execute();
		$statement->setFetchMode(PDO::FETCH_CLASS, 'Ingredient');
		$ingredients = array();

		while ($result = $statement->fetch()) {
			array_push($ingredients, $result);
		}

		return $ingredients;
	}

	public function create($id) {}

	public function update($id) {}

	public function delete($id) {}

}
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

	public function create($id) {}

	public function update($id) {}

	public function delete($id) {}

}
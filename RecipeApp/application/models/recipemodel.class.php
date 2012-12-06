<?php

class RecipeModel extends Model {

	public function view($id) {
		$recipe = new Recipe();
		$query = 'SELECT name FROM recipes WHERE id = :id';
		$statement = $this->connection->prepare($query);
		$statement->bindParams(':id', $id);
		$statement->execute();
		$statement->fetch(PDO::FETCH_INTO, $recipe);
		$ingredients = $this->getIngredients($id);
		$recipe->setIngredients($ingredients);

		return $recipe;
	}

	public function create($id) {}

	public function update($id) {}

	public function delete($id) {}

	protected function getIngredients($id) {
		try {
			$ingredientModel = new ingredientModel();
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		return $ingredientModel->viewSet($id);
	}

}
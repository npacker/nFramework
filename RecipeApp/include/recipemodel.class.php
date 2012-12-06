<?php

class RecipeModel extends Model {

	public function __construct() {

		echo 'Called ' . __METHOD__ . "\n";

		parent::__construct();
	}

	public function view($id) {

		echo 'Called ' . __METHOD__ . "\n";

		$recipe = new Recipe();
		$query = 'SELECT name FROM recipes WHERE id = :id';
		$statement = $this->connection->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->setFetchMode(PDO::FETCH_INTO, $recipe);
		$statement->execute();
		$statement->fetch();
		$ingredients = $this->getIngredients($id);
		$recipe->setIngredients($ingredients);

		echo 'Recipe Name: ' . $recipe->name();

		return $recipe;
	}

	public function edit($id) {}

	public function create($id) {}

	public function update($id) {}

	public function delete($id) {}

	protected function getIngredients($id) {

		echo 'Called ' . __METHOD__ . "\n";

		try {
			$ingredientModel = new ingredientModel();
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		return $ingredientModel->viewSet($id);
	}

}
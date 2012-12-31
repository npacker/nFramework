<?php

class RecipeModel extends Model {

	public function __construct() {
		echo 'Called ' . __METHOD__ . "<br />";
		parent::__construct();
	}

	public function find($id) {
		echo 'Called ' . __METHOD__ . "<br />";
		$query = 'SELECT name FROM recipes WHERE id = :id';

		try {
			$statement = $this->connection->prepare($query);
			$statement->bindParam(':id', $id);
			$statement->setFetchMode(PDO::FETCH_CLASS, 'Recipe');
			$statement->execute();
			$recipe = $statement->fetch();
			$statement->closeCursor();
			$this->ingredients($id, $recipe);
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}

		return $recipe;
	}

	public function join($id, $field) {}

	public function all() {
		echo 'Called ' . __METHOD__ . "<br />";
		$query = 'SELECT name FROM recipes';

		try {
			$statement = $this->connection->prepare($query);
			$statement->setFetchMode(PDO::FETCH_CLASS, 'Recipe');
			$statement->execute();
			$recipeList = new RecipeList();

			foreach($statement as $recipe) {
				$recipeList->addRecipe($recipe);
			}

			$statement->closeCursor();
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		} catch (FileNotFoundException $e) {
			echo $e->getMessage();
			exit();
		}

		return $recipeList;
	}

	public function create(Recipe $recipe=null) {
		echo 'Called ' . __METHOD__ . "<br />";
		$query = 'INSERT INTO recipes (name) VALUES (:name)';

		try {
			$statement = $this->connection->prepare($query);
			$statement->bindParam(':name', $recipe->getName());
			$statement->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}
	}

	public function update($id, Recipe $recipe=null) {
		echo 'Called ' . __METHOD__ . "<br />";
	}

	public function delete($id) {
		echo 'Called ' . __METHOD__ . "<br />";
		$query = 'DELETE FROM recipes WHERE id = :id';

		try {
			$statement = $this->connection->prepare($query);
			$statement->bindParam(':id', $id);
			$statement->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}
	}

	protected function ingredients($id, &$recipe) {
		echo 'Called ' . __METHOD__ . "<br />";

		try {
			$ingredientModel = new ingredientModel();
		} catch (FileNotFoundException $e) {
			echo $e->getMessage();
			exit();
		}

		$ingredients = $ingredientModel->join($id, 'recipe_id');

		foreach ($ingredients as $ingredient) {
			$recipe->addIngredient($ingredient);
		}
	}

}
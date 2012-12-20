<?php

class RecipeModel extends Model {

	public function __construct() {

		echo 'Called ' . __METHOD__ . "<br />";

		parent::__construct();
	}

	public function view($id) {

		echo 'Called ' . __METHOD__ . "<br />";

		$query = 'SELECT name FROM recipes WHERE id = :id';
		$statement = $this->connection->prepare($query);
		$statement->bindParam(':id', $id);
		$statement->setFetchMode(PDO::FETCH_CLASS, 'Recipe');

		try {
			$statement->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
			exit();
		}

		$recipe = $statement->fetch();
		$statement->closeCursor();
		$ingredients = $this->getIngredients($id);
		$recipe->setIngredients($ingredients);

		return $recipe;
	}

	public function viewRel($id, $field) {}

	public function all() {

		echo 'Called ' . __METHOD__ . "<br />";

		$query = 'SELECT name FROM recipes';
		$statement = $this->connection->prepare($query);
		$statement->setFetchMode(PDO::FETCH_CLASS, 'Recipe');

		try {
			$statement->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
			exit();
		}

		try {
			$recipeList = new RecipeList();
		} catch (Exception $e) {
			echo $e->getMessage();
			exit();
		}

		foreach($statement as $recipe) {
			$recipeList->addRecipe($recipe);
		}

		$statement->closeCursor();

		return $recipeList;
	}

	public function create(Array $data) {

		echo 'Called ' . __METHOD__ . "<br />";

		$name = $data['name'];
		$query = 'INSERT INTO recipes (name) VALUES (:name)';
		$statement = $this->connection->prepare($query);
		$statement->bindParam(':name', $name);

		try {
			$statement->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
			exit();
		}
	}

	public function update($id, Array $data) {

		echo 'Called ' . __METHOD__ . "<br />";

	}

	public function delete($id) {

		echo 'Called ' . __METHOD__ . "<br />";

		$query = 'DELETE FROM recipes WHERE id = :id';
		$statement = $this->connection->prepare($query);
		$statement->bindParam(':id', $id);

		try {
			$statement->execute();
		} catch (Exception $e) {
			echo $e->getMessage();
			exit();
		}
	}

	protected function getIngredients($id) {

		echo 'Called ' . __METHOD__ . "<br />";

		try {
			$ingredientModel = new ingredientModel();
		} catch (Exception $e) {
			echo $e->getMessage();
			exit();
		}

		return $ingredientModel->viewRel($id, 'recipe_id');
	}

}
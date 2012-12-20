<?php

class RecipeModel extends Model {

	public function __construct() {

		echo 'Called ' . __METHOD__ . "<br />";

		parent::__construct();
	}

	public function view($id=null) {

		echo 'Called ' . __METHOD__ . "<br />";

		if (isset($id) && is_numeric($id)) {
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
	}

	public function viewRel($id, $field) {}

	public function create() {

		echo 'Called ' . __METHOD__ . "<br />";

		$name = $_POST['name'];
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

	public function update($id) {}

	public function delete($id) {}

	protected function getIngredients($id) {

		echo 'Called ' . __METHOD__ . "<br />";

		try {
			$ingredientModel = new ingredientModel();
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		return $ingredientModel->viewRel($id, 'recipe_id');
	}

}

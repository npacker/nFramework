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
			echo $e->getMessage;
			exit();
		}
		$recipe = $statement->fetch();
		$ingredients = $this->getIngredients($id);
		$recipe->setIngredients($ingredients);

		return $recipe;
	}

	public function create() {

		echo 'Called ' . __METHOD__ . "<br />";

		list($name) = $_POST;
		$query = 'INSERT INTO recipes (name) VALUES (:name)';
		$statement = $this->connection->prepare($query);
		$statement->bindParam(':name', $name);
		try {
			$statement->execute();
		} catch (Exception $e) {
			echo $e->getMessage;
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

		return $ingredientModel->viewSet($id);
	}

}
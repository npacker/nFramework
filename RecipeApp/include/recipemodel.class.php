<?php

class RecipeModel extends Model {

	public function __construct() {
		parent::__construct();
	}

	public function find($id) {
		try {
			$this->database->connect();
			$recipe = $this->database->query('recipes', array('name'))
				->where('id', $id)
				->resultClass('Recipe')
				->fetch();
			$this->database->close();
		} catch (PDOExcpetion $e) {
			echo $e->getMessage();
			exit();
		}

		return $recipe;
	}

	public function join($id, $field) {}

	public function all() {
		$recipeList = new RecipeList();

		try {
			$this->database->connect();
			$result = $this->database->query('recipes', array('name'))
				->resultClass('Recipe')
				->fetch();

			foreach($result as $recipe) {
				$recipe_List->addRecipe($recipe);
			}

			$this->database->close();
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
		try {
			$this->database->connect();
			$result = $this->database->query('recipes', array('name'))
				->save(array('name', $recipe->name));
			$lastInsertId = $result->lastInsertId('id');
			$this->database->close();
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}

		return $lastInsertId;
	}

	public function update($id, Recipe $recipe=null) {
		try {
			$this->database->connect();
			$this->database->query('recipes', array('name'))
				->where('id', $id)
				->save(array('name', $recipe->name));
			$this->database->close();
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}
	}

	public function delete($id) {
		try {
			$this->database->connect();
			$this->database->query('recipes')
				->where('id', $id)
				->delete();
			$this->database->close();
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit();
		}
	}

	protected function ingredients($id, &$recipe) {
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
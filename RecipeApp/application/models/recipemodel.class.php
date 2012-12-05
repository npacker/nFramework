<?php

class RecipeModel extends Model {

	public function view($id) {



	}

	protected function getIngredients($id, &$recipe) {
		try {
			$ingredientModel = new ingredientModel();
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		return $ingredientModel->viewAll($id);
	}

}
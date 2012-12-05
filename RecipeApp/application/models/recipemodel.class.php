<?php

class RecipeModel extends Model {

	public function view($id) {
		try {
			$ingredientModel = new ingredientModel();
			$ingredientController = new IngredientController($ingredientModel, __FUNCTION__, $id);
		} catch (Exception $e) {
			echo $e->getMessage();
		}


	}

}
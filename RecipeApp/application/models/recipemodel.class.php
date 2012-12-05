<?php

class RecipeModel extends BaseModel {

	public function view($id) {
		try {
			$ingredientModel = new ingredientModel();
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		try {
			$ingredientController = new IngredientController($ingredientModel, __FUNCTION__, $id);
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		try {
			$stepModel = new stepModel();
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		try {
			$stepController = new stepController($stepModel, __FUNCTION__, $id);
		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}

}
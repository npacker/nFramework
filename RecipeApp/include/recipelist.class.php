<?php

Class RecipeList extends Type {

	protected $recipeList = array();

	public function __construct(Array $recipeList=null) {

		echo 'Called ' . __METHOD__ . "<br />";

		if (isset($recipeList)) $this->recipeList = $recipeList;
	}

	public function addRecipe(Recipe $recipe) {

		echo 'Called ' . __METHOD__ . "<br />";

		array_push($this->recipeList, $recipe);
	}

}
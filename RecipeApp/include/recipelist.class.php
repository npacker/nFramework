<?php

Class RecipeList extends Node {

	protected $recipeList = array();

	public function __construct(Array $recipeList=null) {
		if (isset($recipeList)) $this->recipeList = $recipeList;
	}

	public function addRecipe(Recipe $recipe) {
		array_push($this->recipeList, $recipe);
	}

}
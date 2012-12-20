<?php

Class RecipeList extends Node {

	protected $recipeList;

	public function __construct(Array $recipeList=null) {
		$this->recipeList = $recipeList;
	}

	public function addRecipe(Recipe $recipe) {
		array_push($this->recipeList, $recipe);
	}

}
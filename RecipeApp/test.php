<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());

require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');

bootstrapInit();

$database = MySqlDatabase::instance(DB_HOSTNAME, DB_DATABASE, DB_USERNAME, DB_PASSWORD);
$database->connect();

$recipe = $database->query()
	->from('recipes', array('name'))
	->fetchClass('Recipe');

$result = $database->query()
	->from('recipes')
	->fetchBoth();

$database->query()
	->from('recipes')
	->save(array('name' => 'Test Recipe 2'));

$database->query()
	->from('recipes')
	->where('name', 'Test Recipe 2')
	->save(array('name' => 'Test Recipe 3'));

$result = $database->query()
	->from('recipes', array('id'))
	->where('name', 'Test Recipe 2')
	-fetchBoth();

$recipe_id = $result['id'];

$database->query()
	->from('ingredients')
	->save(array('name' => 'Eggs', 'quantity' => 2, 'recipe_id' => $recipe_id));

$database->query()
	->from('recipes')
	->where('name', 'Test Recipe 3')
	->delete();
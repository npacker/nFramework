<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());

require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');

bootstrapInit();

$database = MySqlDatabase::instance(DB_HOSTNAME, DB_DATABASE, DB_USERNAME, DB_PASSWORD);
$database->connect();

try {
	$recipe = $database->query('recipes', array('name'))
		->resultClass('Recipe')
		->fetch();
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

echo "<strong>{$recipe->name}</strong><br />";

try {
	$result = $database->query('recipes')
		->resultClass('Recipe');
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

try {
	while ($recipe = $result->fetch()) {
		echo "<strong>{$recipe->name}</strong><br />";
	}
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

try {
	$database->query('recipes')
		->save(array(
				'name' => 'Test Recipe 3',
			));
		echo "<strong>Saved Test Recipe 3 to database.</strong><br />";
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

try {
	$database->query('recipes')
		->where('name', 'Test Recipe 2')
		->save(array(
				'name' => 'Test Recipe 4',
			));
		echo "<strong>Renamed Test Recipe 2 to Test Recipe 4</strong><br />";
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

try {
	$result = $database->query('recipes', array('id'))
		->where('name', 'Test Recipe 3')
		->resultBoth()
		->fetch();
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

$recipe_id = $result['id'];

try {
	$database->query('ingredients')
		->save(array(
				'name' => 'Eggs',
				'quantity' => 2,
				'recipe_id' => $recipe_id
			));
		echo "<strong>Ingredient Eggs added.</strong><br />";
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

try {
	$database->query('recipes')
		->where('name', 'Test Recipe 3')
		->delete();
	echo "<strong>Test Recipe 3 deleted.</strong><br />";
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

try {
	$ingredient = $database->query('ingredients')
		->where('name', 'Eggs')
		->resultClass('Ingredient')
		->fetch();
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

echo "<strong>{$ingredient->name}</strong><br />";
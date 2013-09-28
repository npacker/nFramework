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

echo "{$recipe->name}";
echo "<br />";

try {
	$result = $database->query('recipes')
		->resultClass('Recipe');
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

try {
	while ($recipe = $result->fetch()) {
		echo "{$recipe->name}<br />";
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
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

try {
	$database->query('recipes')
		->where('name', 'Test Recipe 3')
		->delete();
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

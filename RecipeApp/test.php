<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());

require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');

bootstrap_init();

global $databases;

$hostname = $databases['default']['hostname'];
$database = $databases['default']['database'];
$username = $databases['default']['username'];
$password = $databases['default']['password'];

$database = MySqlDatabase::instance($hostname, $database, $username, $password);
$database->connect();

try {
	$result = $database->query('recipes', array('name'))
		->resultBoth()
		->fetch();
	
	echo "<strong>The first recipe in the database is: {$result['name']}.</strong><br />";
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

try {
	$result = $database->query('recipes')
		->resultBoth();
	
	echo "<strong>The following recipes are in the database:</strong><br />";
	
	while ($recipe = $result->fetch()) {
	  echo "<strong>{$recipe['name']} is in the database.</strong><br />";
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
  $result = $database->query('recipes')
    ->constrain('name', 'Test Recipe 3')
    ->resultBoth()
    ->fetch();
  
  echo "<strong>{$result['name']} is in the database.</strong><br />";
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

try {
	$database->query('recipes')
		->constrain('name', 'Test Recipe 2')
		->save(array(
				'name' => 'Test Recipe 4',
			));
	
	echo "<strong>Test Recipe 2 was renamed as Test Recipe 4.</strong><br />";
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

try {
  $result = $database->query('recipes')
  ->constrain('name', 'Test Recipe 4')
  ->resultBoth()
  ->fetch();

  echo "<strong>{$result['name']} is in the database.</strong><br />";
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}

try {
  $result = $database->query('recipes')
  ->constrain('name', 'Test Recipe 2')
  ->resultBoth()
  ->fetch();

  if (empty($result)) {
    echo "<strong>Test Recipe 2 is no longer in the database.</strong><br />";
  } else {
    echo "<strong>{$result['name']} is in the database.</strong><br />";
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}

try {
	$result = $database->query('recipes', array('id'))
		->constrain('name', 'Test Recipe 3')
		->resultBoth()
		->fetch();
	
	$recipe_id = $result['id'];
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

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
		->constrain('name', 'Test Recipe 3')
		->delete();
	
	echo "<strong>Test Recipe 3 was deleted.</strong><br />";
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

try {
  $result = $database->query('recipes')
  ->constrain('name', 'Test Recipe 3')
  ->resultBoth()
  ->fetch();

  if (empty($result)) {
    echo "<strong>Test Recipe 3 is no longer in the database.</strong><br />";
  } else {
    echo "<strong>Test Recipe 3 is still in the database: {$result['name']}.</strong><br />";
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}

try {
  $result = $database->query('recipes')
    ->resultBoth();

  echo "<strong>The following recipes are in the database:</strong><br />";

  while ($recipe = $result->fetch()) {
    echo "<strong>{$recipe['name']} is in the database.</strong><br />";
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}

try {
  $result = $database->query('recipes')
    ->constrain('name', 'Test Recipe 4')
    ->constrainOr('name', 'Test Recipe 1')
    ->order('name', 'DESC')
    ->resultBoth();

  echo "<strong>The following recipes were selected:</strong><br />";

  while ($recipe = $result->fetch()) {
    echo "<strong>{$recipe['name']} is in the database.</strong><br />";
  }
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
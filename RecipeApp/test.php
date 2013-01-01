<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());

require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');

bootstrapInit();

$database = MySqlDatabase::instance(DB_HOSTNAME, DB_DATABASE, DB_USERNAME, DB_PASSWORD);
$database->connect();
$recipe = $database->query()
	->from('recipes')
	->where('id', '=', 1)
	->fetchClass('Recipe');
print_r($recipe);
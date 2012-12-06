<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());

require_once (ROOT . DS . 'library' . DS . 'config.php');
require_once (ROOT . DS . 'library' . DS . 'autoload.php');

$query = 'DROP TABLE IF EXISTS recipes;
					CREATE TABLE recipes
					(
						id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
						name VARCHAR(255) NOT NULL
					);';

$connection = MySqlConnection::getConnection();

try {
	$statement = $connection->prepare($query);
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}

try {
	$statement->execute();
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}
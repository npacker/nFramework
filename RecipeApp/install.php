<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());

require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');

bootstrapInit();

$query = <<<QUERY
DROP DATABASE IF EXISTS recipesdb;
CREATE DATABASE IF NOT EXISTS recipesdb;
USE recipesdb;
DROP TABLE IF EXISTS ingredients;
DROP TABLE IF EXISTS recipes;
CREATE TABLE IF NOT EXISTS recipes
(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	name VARCHAR(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS ingredients
(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	name VARCHAR(255) NOT NULL,
	quantity INT NOT NULL,
	recipe_id INT NOT NULL,
	CONSTRAINT ingredients_fk_recipes
		FOREIGN KEY (recipe_id) REFERENCES recipes(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);
INSERT INTO recipes
	(name)
VALUES
	("Test Recipe 1"),
	("Test Recipe 2");
INSERT INTO ingredients
	(name, quantity, recipe_id)
VALUES
	("Test Ingredient 1", 1, 1);
QUERY;

try {
	$connection = MySqlConnection::getConnection();
} catch (PDOException $e) {
	echo $e->getMessage();
	exit();
}

$statement = $connection->prepare($query);

try {
	$statement->execute();
} catch (PDOException $e) {
	echo $e->getMessage;
	exit();
}

$statement->closeCursor();
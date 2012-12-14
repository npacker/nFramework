<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());

require_once (ROOT . DS . 'library' . DS . 'config.php');
require_once (ROOT . DS . 'library' . DS . 'autoload.php');

$query = 'DROP TABLE IF EXISTS ingredients;
					CREATE TABLE ingredients
					(
						id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
						name VARCHAR(255) NOT NULL,
						quantity INT NOT NULL,
						recipe_id INT NOT NULL,
						CONSTRAINT ingredients_fk_recipes
							FOREIGN KEY (recipe_id)
							REFERENCES recipes(id)
							ON UPDATE CASCADE
							ON DELETE CASCADE
					);
					DROP TABLE IF EXISTS recipes;
					CREATE TABLE recipes
					(
						id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
						name VARCHAR(255) NOT NULL
					);
					INSERT INTO ingredients (name, quantity, recipe_id) VALUES ("Test Ingredient 1", "1", "1");';

$connection = MySqlConnection::getConnection();
$statement = $connection->prepare($query);
$statement->execute();
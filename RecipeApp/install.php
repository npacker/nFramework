<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());

require_once (ROOT . DS . 'library' . DS . 'config.php');
require_once (ROOT . DS . 'library' . DS . 'autoload.php');

$query = 'DROP DATABASE recipesdb;
					CREATE DATABASE recipesdb;
					DROP TABLE IF EXISTS recipes;
					CREATE TABLE recipes
					(
						id INT PRIMARY_KEY AUTO_INCREMENT NOT NULL,
						name VARCHAR(255) NOT NULL
					);
					DROP TABLE IF EXISTS ingredients;
					CREATE TABLE ingredients
					(
						id INT PRIMARY_KEY AUTO_INCREMENT NOT NULL,
						name VARCHAR(255) NOT NULL,
						quantity INT NOT NULL
					);';

$connection = MySqlConnection::getConnection();

try {
	$statement = $connection->prepare($query);
} catch (Exception $e) {
	echo $e->getMessage();
}

try {
	$statement->execute();
} catch (Exception $e) {
	echo $e->getMessage();
}
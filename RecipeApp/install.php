<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());

require_once (ROOT . DS . 'library' . DS . 'autoload.php');

$query = 'DROP DATABASE recipesdb;
					CREATE DATABASE recipesdb;
					USE recipesdb;
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
$statement = $connection->prepare($query);
try {
	$statement->execute();
} catch (Exception $e) {
	echo $e->getMessage();
	exit();
}
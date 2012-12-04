<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__));

$url = $_GET['url'];

require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');
<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());

require_once ROOT . DS . 'system' . DS . 'bootstrap.php';

bootstrap();
$app = new Application();
$app->serve(
  new Request($_GET, $_POST, $_SERVER),
  new Response()
);
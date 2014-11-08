<?php

use nFramework\Application;
use nFramework\Request;

require_once 'nFramework' . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = new Application();

$app->packages(array(
  new Package('Nigel:WebsitePackage')
));

$app->serve(new Request($_GET, $_POST, $_SERVER));
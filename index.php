<?php

use nFramework\Application;
use nFramework\Package;
use nFramework\Request;

require_once 'application' . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = new Application();
$app->registerPackage(new Package('Nigel:WebsitePackage'));
$app->handle(new Request($_GET, $_POST, $_SERVER));
<?php

namespace nFramework;

use Exception;
use ErrorException;
use nFramework\Exception\FileNotFoundException;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());

function autoload_class($class) {
  if (strpos($class, '\\')) {
    $filename = str_replace('\\', DS, $class);
    $file = $filename . '.class.php';

    if (is_readable($file)) {
      require_once $file;
    }
  } else {
    $directories = array('actions', 'model', 'services');

    foreach ($directories as $directory) {
      $file = ROOT . DS . $directory . DS. $class . '.class.php';

      if (is_readable($file)) {
        require_once $file;
        break;
      }
    }
  }
}

function fatal_error_handler() {
  $error = error_get_last();

  if ($error['type'] == E_ERROR) {
    error_handler(
      $error['type'],
      $error['message'],
      $error['file'],
      $error['line']);
  }
}

function error_handler($errno, $errstr, $errfile, $errline) {
  throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

function exception_handler(Exception $exception) {
  echo 'Uncaught exception: ' . $exception->getMessage() . ' on line ' . $exception->getLine() . ' of ' . $exception->getFile();
  exit();
}

function settings_init() {
  global $databases;

  require_once ROOT . DS . 'config' . DS . 'config.php';
}

function bootstrap() {
  ini_set('display_errors', 'on');
  error_reporting(E_ALL & ~E_NOTICE);

  register_shutdown_function('nFramework\fatal_error_handler');
  set_error_handler('nFramework\error_handler');
  set_exception_handler('nFramework\exception_handler');
  spl_autoload_register('nFramework\autoload_class');

  settings_init();

  require_once ROOT . DS . 'nFramework' . DS . 'common.php';
}

bootstrap();
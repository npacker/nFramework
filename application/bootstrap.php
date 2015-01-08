<?php

namespace nFramework;

use Exception;
use ErrorException;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd());

function file_parts($class, &$file, &$namespace) {
  $file = explode('\\', $class);
  $namespace = implode(DS, array_splice($file, 0, 2));
  $file = implode(DS, $file);
}

function require_file($file) {
  if (is_readable($file)) {
    require_once $file;
  }
}

function autoload_action($class) {
  file_parts($class, $file, $namespace);
  require_file(ROOT . DS . 'packages' . DS . $namespace . DS . 'Controller' . DS . $file . '.class.php');
}

function autoload_model($class) {
  file_parts($class, $file, $namespace);
  require_file(ROOT . DS . 'packages' . DS . $namespace . DS . 'Model' . DS . $file . '.class.php');
}

function autoload_core($class) {
  $file = str_replace('\\', DS, $class);
  require_file(ROOT . DS . str_replace('nFramework', 'application', $file) . '.class.php');
}

function fatal_error_handler() {
  $error = error_get_last();

  switch ($error['type']) {
    case E_ERROR:
    case E_PARSE:
    case E_COMPILE_ERROR:
    echo sprintf('Fatal error: %s in %s on line %d', $error['message'], $error['file'], $error['line']);
    exit();
  }
}

function error_handler($errno, $errstr, $errfile, $errline) {
  clean_all_buffers();
  throw new ErrorException(sprintf('%s in %s on line %d', $errstr, $errfile, $errline), 0, $errno, $errfile, $errline);
}

function exception_handler(Exception $exception) {
  echo sprintf('Uncaught exception: %s on line %d of %s', $exception->getMessage(), $exception->getLine(), $exception->getFile());
  exit();
}

function settings_init() {
  global $databases;

  include ROOT . DS . 'config' . DS . 'config.php';
}

function bootstrap() {
  ini_set('display_errors', 0);
  ini_set('error_reporting', E_ALL);
  ini_set('session.cookie_httponly', 1);
  ini_set('include_path', ROOT);

  register_shutdown_function('nFramework\fatal_error_handler');
  set_error_handler('nFramework\error_handler');
  set_exception_handler('nFramework\exception_handler');

  spl_autoload_register('nFramework\autoload_action');
  spl_autoload_register('nFramework\autoload_model');
  spl_autoload_register('nFramework\autoload_core');

  settings_init();

  require_once ROOT . DS . 'application' . DS . 'common.php';
}

bootstrap();

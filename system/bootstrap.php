<?php

function __include_file($class) {
  $directories = array(
    'system',
    'system' . DS . 'exceptions',
    'system' . DS . 'interfaces',
    'domain',
    'actions',
    'services');

  $filename = str_replace('\\', DS, $class);

  foreach ($directories as $directory) {
    $file = ROOT . DS . $directory . DS . $filename . '.class.php';

    if (is_readable($file)) return require_once $file;
  }

  throw new FileNotFoundException("Could not load {$file}.");
}

function fatal_error_check() {
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
  register_shutdown_function('fatal_error_check');
  set_error_handler('error_handler');
  set_exception_handler('exception_handler');
  ini_set('display_errors', 'on');
  error_reporting(E_ALL);
  spl_autoload_register('__include_file');
  settings_init();
  require_once ROOT . DS . 'system' . DS . 'common.php';
}
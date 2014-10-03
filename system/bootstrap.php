<?php

function __include_file($class) {
  $directories = array('system','includes');
  $filename = strtolower($class);

  foreach ($directories as $directory) {
    $file = ROOT . DS . $directory . DS . $filename . '.class.php';

    if (is_readable($file)) return require_once $file;
  }

  throw new FileNotFoundException("Could not load {$filename}.");
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
  echo "An error occured on line {$errline} of {$errfile} with the message \"{$errstr}\".";
  exit();
}

function exception_handler($exception) {
  echo 'Uncaught exception: ' . $exception->getMessage();
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
  ini_set('display_errors', 'off');
  error_reporting(E_ALL);
  spl_autoload_register('__include_file');
  settings_init();
  require_once ROOT . DS . 'system' . DS . 'common.php';
}
<?php

function base_path() {
  static $base_path;

  if (!isset($base_path)) {
    $base_path = $_SERVER['SCRIPT_NAME'];
    $base_path = explode('/', $base_path);
    array_pop($base_path);
    $base_path = implode('/', $base_path);
  }

  return $base_path;
}

function base_url() {
  static $base_url;

  if (!isset($base_url)) {
    $base_url = protocol() . '://' . $_SERVER['HTTP_HOST'];
  }

  return $base_url;
}

function clean_all_buffers() {
  while (ob_get_level() != 0) {
    ob_end_clean();
  }
}

function is_secure() {
  return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' || $_SERVER['SERVER_PORT'] == 443);
}

function protocol() {
  return (is_secure()) ? 'https' : 'http';
}

function url() {
  $argv = func_get_args();
  $url = base_url() . base_path();

  foreach ($argv as $arg) {
    $url .= '/' . $arg;
  }

  return $url;
}

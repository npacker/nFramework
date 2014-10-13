<?php

class ActionFactory {

  public function get($action) {
    $className = $action . 'Action';

    if ($className == 'Action' || !class_exists($className, true)) {
      throw new ActionNotFoundException("Action {$className} is undefined.");
    }

    $class = new $className();

    extract($this->loadConfig($action));

    foreach ($preprocessors as $preprocessor) {
      $class = new $preprocessor($class);
    }

    return $class;
  }

  protected function loadConfig($action) {
    $filename = strtolower($action);
    $path = ROOT . DS . 'actions' . DS . $filename . '.json';

    if (file_exists($path)) {
      $file = file_get_contents($path);
    } else {
      $file = '{}';
    }

    $default = file_get_contents(ROOT . DS . 'actions' . DS . 'default.json');

    $config = array_replace(
      json_decode($default, true),
      json_decode($file, true));

    return $config;
  }

}
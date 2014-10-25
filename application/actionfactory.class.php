<?php

class ActionFactory {

  public function build(Request $request) {
    $patterns = $this->loadPatterns();

    foreach ($patterns as $pattern => $config) {
      $matcher = new PathMatcher($pattern);

      if ($matcher->match($request->path())) {
        $action = $config['action'];

        break;
      }
    }
  }

  public function getAction($action) {
    $className = $action . 'Action';

    if ($className == 'Action' || !class_exists($className, true)) {
      throw new ActionNotFoundException("Action {$className} is undefined.");
    }

    $class = new $className();
    $config = $this->loadConfig($action);

    foreach ($config['preprocessors'] as $preprocessor) {
      $class = new $preprocessor($class);
    }

    return $class;
  }

  protected function loadPatterns() {
    $path = ROOT . DS . 'config' . DS . 'paths.json';

    if (!file_exists($path)) {
      throw new FileNotFoundException('Paths configuration could not be loaded.');
    } else if (!is_readable($path)) {
      throw new RuntimeException('Path configuration file was not readable');
    }

    $json = file_get_contents($path);

    return json_decode($json);
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
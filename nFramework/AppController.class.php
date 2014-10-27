<?php

final class AppController {

  private $action;

  private $config;

  private $paths;

  private $view;

  public function __construct() {
    $this->paths = $this->loadPaths();
  }

  public function build(Request $request) {
    $paths = $this->loadPatterns();
    $matched = false;

    foreach ($paths as $pattern => $config) {
      $matcher = new PathMatcher($pattern);

      if ($matcher->match($request->path())) {
        $matched = true;
        $this->config = $config;

        if (property_exists($config, 'action')) {
          $this->action = $config->action . 'Action';
        }

        if (property_exists($config, 'view')) {
          $this->view = $config->view . 'View';
        }
      }
    }

    if (!$matched) {
      throw new ResourceNotFoundException();
    }
  }

  public function getAction() {
    if ($action = $this->instantiate($this->action)) {
      foreach ($this->config->preprocessors as $preprocessor) {
        $action = new $preprocessor($action);
      }

      return $action;
    }

    return null;
  }

  public function getView() {
    return $this->instantiate($this->view);
  }

  private function instantiate($classname) {
    if ($classname) {
      $class = new $classname();

      return $class;
    }

    return null;
  }

  private function loadPaths() {
    $path = ROOT . DS . 'config' . DS . 'paths.json';

    if (!file_exists($path)) {
      throw new FileNotFoundException('Paths configuration file could not be loaded.');
    } else if (!is_readable($path)) {
      throw new RuntimeException('Path configuration file was not readable');
    }

    $json = file_get_contents($path);

    return json_decode($json);
  }

}
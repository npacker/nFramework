<?php

namespace nFramework;

use RuntimeException;
use nFramework\Exception\FileNotFoundException;
use nFramework\Exception\ResourceNotFoundException;

final class AppController {

  private $action;

  private $config;

  private $paths;

  private $view;

  private $parameters;

  public function __construct() {
    $this->paths = $this->loadPaths();
  }

  public function build(Request $request) {
    foreach ($this->paths as $pattern => $config) {
      $matcher = new PathMatcher($pattern);

      if ($matcher->match($request->path())) {
        $this->config = $config;
        $this->parameters = $matcher->parameters();

        if (property_exists($config, 'action')) {
          $this->action = $config->action . 'Action';
        }

        if (property_exists($config, 'view')) {
          $this->view = $config->view . 'View';
        }

        return $this;
      }
    }

    throw new ResourceNotFoundException();
  }

  public function getAction() {
    if ($action = $this->instantiate($this->action)) {
      if (isset($this->config->preprocessors)) {
        foreach ($this->config->preprocessors as $preprocessor) {
          $action = new $preprocessor($action);
        }
      }

      return $action;
    }

    return null;
  }

  public function getParameters() {
    return $this->parameters;
  }

  public function getView() {
    return $this->instantiate($this->view);
  }

  private function instantiate($classname) {
    if ($classname) {
      if (!class_exists($classname)) {
        throw new RuntimeException('Class ' . $classname . ' is undefined.');
      }

      return $class = new $classname();
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

    $json = json_decode(file_get_contents($path));

    if (!$json) {
      throw new RuntimeException(json_last_error_msg());
    }

    return $json;
  }

}
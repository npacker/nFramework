<?php

namespace nFramework;

use RuntimeException;
use nFramework\Exception\FileNotFoundException;
use nFramework\Exception\ResourceNotFoundException;

final class AppController {

  private $action;

  private $packages;

  private $path;

  private $paths;

  private $view;

  private $parameters;

  public function __construct(array $packages) {
    $this->packages = $packages;
    $this->paths = $this->loadPaths($packages);
  }

  public function build(Request $request) {
    foreach ($this->paths as $pattern => $path) {
      $matcher = new PathMatcher($pattern);

      if ($matcher->match($request->path())) {
        $this->path = $path;
        $this->parameters = $matcher->getParameters();

        if (property_exists($path, 'action')) {
          $this->setAction($this->classname($path->action));
        }

        if (property_exists($path, 'view')) {
          $this->setView($this->classname($path->view));
        }

        return $this;
      }
    }

    throw new ResourceNotFoundException();
  }

  public function getAction() {
    if ($action = $this->instantiate($this->action)) {
      if (isset($this->path->preprocessors)) {
        foreach ($this->path->preprocessors as $preprocessor) {
          $action = $this->instantiate("nFramework\\Service\\" . $preprocessor, $action);
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

  public function setAction($action) {
    $this->action = $action . 'Action';
  }

  public function setView($view) {
    $this->view = $view . 'View';
  }

  private function classname($class) {
    return str_replace(':', '\\', $class);
  }

  private function instantiate($classname, $parameter = null) {
    if ($classname) {
      if (!class_exists($classname)) {
        throw new RuntimeException('Class ' . $classname . ' is undefined.');
      }

      return $class = new $classname($parameter);
    }

    return null;
  }

  private function loadPaths(array $packages) {
    $paths = array();

    foreach ($packages as $package) {
      $paths = array_merge($paths, (array) $package->getConfig());
    }

    return $paths;
  }

}

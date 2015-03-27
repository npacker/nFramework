<?php

namespace nFramework;

use RuntimeException;
use nFramework\Exception\ResourceNotFoundException;

final class AppController {

  private $action;

  private $container;

  private $packages;

  private $parameters;

  private $path;

  private $paths;

  public function __construct(array $packages) {
    $this->container = new DependencyContainer();
    $this->packages = $packages;
    $this->paths = $this->loadPaths($packages);
  }

  public function build(Request $request) {
    foreach ($this->paths as $pattern => $path) {
      $matcher = new PathMatcher($pattern);

      if ($matcher->match($request->path())) {
        $this->path = $path;
        $this->parameters = $matcher->getParameters();
        $this->setAction(str_replace(':', '\\', $this->path->action));

        return $this;
      }
    }

    throw new ResourceNotFoundException();
  }

  public function getAction() {
    $action = $this->container->build($this->action);

    if (isset($this->path->preprocessors)) {
      foreach ($this->path->preprocessors as $preprocessor) {
        $concrete = "nFramework\\Service\\" . $preprocessor;
        $action = new $concrete($action);
      }
    }

    return $action;
  }

  public function getParameters() {
    return $this->parameters;
  }

  public function setAction($action) {
    $this->action = $action . 'Action';
  }

  private function loadPaths(array $packages) {
    $paths = array();

    foreach ($packages as $package) {
      $paths = array_merge($paths, (array) $package->getConfig());
    }

    return $paths;
  }

}

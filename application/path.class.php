<?php

namespace nFramework\Application;

class Path {

  protected $value;

  protected $components;

  public function __construct(Request $request) {
    $this->value = $this->parseRequest($request);
    $this->components = explode('/', trim($this->value, '/'));
  }

  public function __toString() {
    return (string) $this->value;
  }

  public function value() {
    return (string) $this;
  }

  public function components() {
    return $this->components;
  }

  protected function parseRequest(Request $request) {
    $requestUri = str_replace(base_path(), '', $request->server('REQUEST_URI'));
    $path = strstr($requestUri, '?', true);

    if (!$path) $path = $requestUri;

    return $path;
  }

}
<?php

class Request {
  protected $get;
  protected $path;
  protected $post;
  protected $server;
  protected $uri;

  public function __construct($get, $post, $server) {
    $this->get = $get;
    $this->post = $post;
    $this->server = $server;
    $this->uri = $this->parseRequestUri(base_path());

    if (!empty($this->uri)) {
      $this->path = $this->parsePath($this->uri);
    }
  }

  public function getArguments() {
    return array_map('strtolower', explode('/', trim($this->path, '/')));
  }

  public function getGet() {
    return $this->get;
  }

  public function getPath() {
    return $this->path;
  }

  public function getPost() {
    return $this->post;
  }

  public function getUri() {
    return $this->uri;
  }

  protected function parsePath($uri) {
    $path = strstr($uri, '?', true);

    if (!$path) $path = $uri;

    return $path;
  }

  protected function parseRequestUri($basePath) {
    return str_replace($basePath, '', $this->server['REQUEST_URI']);
  }
}
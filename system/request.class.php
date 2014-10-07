<?php

class Request {

  protected $get;

  protected $path;

  protected $post;

  protected $server;

  protected $uri;

  public function __construct(array $get, array $post, array $server) {
    $this->setGet($get);
    $this->setPost($post);
    $this->setServer($server);
    $this->uri = $this->parseRequestUri(
      base_path(),
      $this->server['REQUEST_URI']);

    if (!empty($this->uri)) {
      $this->path = $this->parsePath($this->uri);
    }
  }

  public function getGet($key = null) {
    if (!empty($key)) {
      return $this->get[$key];
    }

    return $this->get;
  }

  public function getPath() {
    return $this->path;
  }

  public function getPathComponents() {
    return array_map('strtolower', explode('/', trim($this->path, '/')));
  }

  public function getPost($key = null) {
    if (!empty($key)) {
      return $this->post[$key];
    }

    return $this->post;
  }

  public function getServer($key = null) {
    if (!empty($key)) {
      return $this->server[$key];
    }

    return $this->server;
  }

  public function getUri() {
    return $this->uri;
  }

  public function setGet(array $get) {
    $this->get = $get;
  }

  public function setPost(array $post) {
    $this->post = $post;
  }

  public function setServer(array $server) {
    $this->server = $server;
  }

  protected function parsePath($uri) {
    $path = strstr($uri, '?', true);

    if (!$path) $path = $uri;

    return $path;
  }

  protected function parseRequestUri($basePath, $requestUri) {
    return str_replace($basePath, '', $requestUri);
  }

}
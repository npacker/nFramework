<?php

namespace nFramework;

class Request {

  protected $get;

  protected $path;

  protected $post;

  protected $query;

  protected $server;

  public function __construct(array $get, array $post, array $server) {
    $this->get = $get;
    $this->post = $post;
    $this->server = $server;
    $this->path = new Path($this);
    $this->query = $this->server('QUERY_STRING');
  }

  public function get($key = null) {
    if ($key) {
      return $this->get[$key];
    }

    return $this->get;
  }

  public function post($key = null) {
    if ($key) {
      return $this->post[$key];
    }

    return $this->post;
  }

  public function server($key = null) {
    if ($key) {
      return $this->server[$key];
    }

    return $this->server;
  }

  public function path() {
    return $this->path;
  }

}
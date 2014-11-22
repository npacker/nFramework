<?php

namespace nFramework;

class Request {

  protected $cookie;

  protected $get;

  protected $path;

  protected $post;

  protected $query;

  protected $server;

  public function __construct(array $cookie, array $get, array $post, array $server) {
    $this->cookie = $cookie;
    $this->get = $get;
    $this->post = $post;
    $this->server = $server;
    $this->path = new Path($this);
    $this->query = $this->server('QUERY_STRING');
  }

  public function cookie($key = null) {
    if ($key) {
      return $this->get[$key];
    }

    return $this->cookie;
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
<?php

class Request {
  protected $uri;
  protected $params = array();
  protected $query = array();

  public function __construct($uri) {
    $this->uri = str_replace(base_path(), '', $uri);
    $this->parseUrl();
  }

  public function getUri() {
    return $this->uri;
  }

  public function getParams() {
    return $this->params;
  }

  public function getQuery() {
    return $this->query;
  }

  protected function parseUrl() {
    if (!empty($this->uri)) {
      $this->params = parse_path(strstr('?', $this->uri, true));
      $this->query = parse_query(strstr('?', $this->uri, false));
    }
  }
}
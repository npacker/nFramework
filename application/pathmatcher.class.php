<?php

class PathMatcher {

  protected $wildcard = '[^\/]+';

  protected $pattern;

  public function __construct($pattern) {
    preg_replace('%', $this->wildcard, $pattern);
    $this->pattern = $pattern;
  }

  public function match(Path $path) {
    if (preg_match($this->pattern, $path->value()) == 1) {
      return true;
    }

    return false;
  }

}
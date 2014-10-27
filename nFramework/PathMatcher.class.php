<?php

namespace nFramework;

class PathMatcher {

  protected $wildcard = '[^\/]+';

  protected $pattern;

  public function __construct($pattern) {
    $pattern = preg_quote($pattern, '/');
    $this->pattern = '/^' . preg_replace('/%/', $this->wildcard, $pattern) . '$/';
  }

  public function match(Path $path) {
    if (preg_match($this->pattern, $path->value()) == 1) {
      return true;
    }

    return false;
  }

}
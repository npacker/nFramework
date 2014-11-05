<?php

namespace nFramework;

class PathMatcher {

  protected $parameterNames = array();

  protected $parameterValues = array();

  protected $regex;

  public function __construct($pattern) {
    $this->regex = $this->buildRegex($pattern);
    $this->parameterNames = $this->parseParameterNames($pattern);
  }

  public function match(Path $path) {
    $values = array();

    if (preg_match($this->regex, $path->value(), $values) == 1) {
      array_shift($values);

      $this->parameterValues = $values;

      return true;
    }

    return false;
  }

  public function parameters() {
    return array_combine($this->parameterNames, $this->parameterValues);
  }

  protected function buildRegex($pattern) {
    return '/^' . $this->replacePlaceholders($this->quote($pattern)) . '$/';
  }

  protected function parseParameterNames($pattern) {
    $names = array();

    preg_match_all('/{([^\/]+)}/', $pattern, $names);
    array_shift($names);

    return array_values(end($names));
  }

  protected function quote($pattern) {
    return preg_replace('/([\/\=\-\+\?\!\$\*\:\<\>])/', '\\\\$1', $pattern);
  }

  protected function replacePlaceholders($subject) {
    return preg_replace('/{[^\/]+}/', '([^\/]+)', $subject);
  }

}
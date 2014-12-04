<?php

namespace nFramework\Model\Validator;

abstract class ValidationStrategy {

  private $name;

  public function __construct($name) {
    $this->name = $name;
  }

  final public function name() {
    return $this->name;
  }

  abstract public function validate($input);

}

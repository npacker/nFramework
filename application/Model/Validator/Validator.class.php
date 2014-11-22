<?php

namespace nFramework\Model\Validator;

use nFramework\Exception\InvalidInputException;

class Validator {

  private $data;

  private $validationStrategy;

  public function __construct(ValidationStrategy $validationStrategy) {
    $this->validationStrategy = $validationStrategy;
  }

  public function __toString() {
    return (string) $this->data;
  }

  public function isSatisfiedBy($input) {
    $this->data = $input;
    $this->validationStrategy->validate($input);
  }

}
<?php

namespace nFramework\Model\Validator;

abstract class ValidationDecorator extends ValidationStrategy {

  private $validationStrategy;

  final public function __construct(ValidationStrategy $validationStrategy) {
    $this->validationStrategy = $validationStrategy;
  }

  final public function name() {
    return $this->validationStrategy->name();
  }

  final public function validate($input) {
    $this->preValidate($input);
    $this->validationStrategy->validate($input);
  }

  abstract protected function preValidate($input);

}
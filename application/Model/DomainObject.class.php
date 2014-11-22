<?php

namespace nFramework\Model;

use nFramework\Model\Validator\Validator;
use nFramework\Model\Validator\ValidationStrategy;

abstract class DomainObject {

  abstract public function __construct(array $data = array());

  final protected function validate($input, ValidationStrategy $validationStrategy) {
    $validator = new Validator($validationStrategy);
    $validator->isSatisfiedBy($input);
  }

}
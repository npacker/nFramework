<?php

namespace nFramework\Model\Validator;

use nFramework\Exception\InvalidInputException;

final class Required extends ValidationDecorator {

  protected function preValidate($input) {
    if (!isset($input)) {
      throw new InvalidInputException($this->name() . ' is required');
    }
  }

}
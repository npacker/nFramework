<?php

namespace nFramework\Model\Validator;

use nFramework\Exception\InvalidInputException;

class Email extends ValidationStrategy {

  public function __construct() {
    parent::__construct('Email');
  }

  public function validate($input) {
    if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
      throw new InvalidInputException('Email address was in an invalid format');
    }
  }

}
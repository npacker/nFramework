<?php

namespace nFramework\Model\Validator;

use nFramework\Exception\InvalidInputException;

class ValidName extends ValidString {

  public function __construct() {
    parent::__construct('Name', "/^[A-Za-z']+$/");
  }

}
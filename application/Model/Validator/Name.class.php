<?php

namespace nFramework\Model\Validator;

use nFramework\Exception\InvalidInputException;

class Name extends String {

  public function __construct() {
    parent::__construct('Name', "/^[A-Za-z']+$/");
  }

}
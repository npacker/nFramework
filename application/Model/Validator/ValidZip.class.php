<?php

namespace nFramework\Model\Validator;

use nFramework\Exception\InvalidInputException;

class ValidZip extends ValidString {

  public function __construct() {
    parent::__construct('Zip', "/^\d{5}(-\d{4})?$/");
  }

}
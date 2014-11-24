<?php

namespace nFramework\Model\Validator;

use nFramework\Exception\InvalidInputException;

class Zip extends String {

  public function __construct() {
    parent::__construct('Zip', "/^\d{5}(-\d{4})?$/");
  }

}
<?php

namespace nFramework\Model\Validator;

use nFramework\Exception\InvalidInputException;

class Money extends String {

  public function __construct() {
    parent::__construct('Price', '/^\d+\.\d{2}$/');
  }

}
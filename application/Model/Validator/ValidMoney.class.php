<?php

namespace nFramework\Model\Validator;

use nFramework\Exception\InvalidInputException;

class ValidMoney extends ValidString {

  public function __construct() {
    parent::__construct('Price', '/^\d+\.\d{2}$/');
  }

}
<?php

namespace nFramework\Model\Validator;

use nFramework\Exception\InvalidInputException;

class String extends ValidationStrategy {

  private $regex;

  public function __construct($name, $regex) {
    parent::__construct($name);
    $this->regex = $regex;
  }

  public function validate($input) {
    if (!preg_match($this->regex, $input)) {
      throw new InvalidInputException($this->name() . ' is in an invalid format');
    }
  }

  protected function regex() {
    return $this->regex;
  }

}
<?php

namespace nFramework\Model\Validator;

use nFramework\Exception\InvalidInputException;

class Number extends ValidationStrategy {

  private $max;

  private $min;

  public function __construct($name, $min = null, $max = null) {
    parent::__construct($name);
    $this->min = $min;
    $this->max = $max;
  }

  public function validate($input) {
    $valid = true;
    $message = $this->name();

    if (!is_numeric($input)) {
      $valid = false;
      $message .= ' was in an invalid format';
    } else if (isset($this->min) && $input < $this->min) {
      $valid = false;
      $message .= ' must be greater than ' . $this->min;
    } else if (isset($this->max) && $input > $this->max) {
      $valid = false;
      $message .= ' must be less than ' . $this->max;
    }

    if (!$valid) {
      throw new InvalidInputException($message);
    }
  }

  protected function max() {
    return $this->max;
  }

  protected function min() {
    return $this->min;
  }

}

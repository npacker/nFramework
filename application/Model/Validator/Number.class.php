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
    if (!is_numeric($input)) {
      throw new InvalidInputException($this->name() . ' was in an invalid format');
    } else if (isset($this->min) && $input < $this->min) {
      throw new InvalidInputException($this->name() . ' must be greater than ' . $this->min);
    } else if (isset($this->max) && $input > $this->max) {
      throw new InvalidInputException($this->name() . ' must be less than ' . $this->max);
    }
  }

  protected function max() {
    return $this->max;
  }

  protected function min() {
    return $this->min;
  }

}

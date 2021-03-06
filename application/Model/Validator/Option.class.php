<?php

namespace nFramework\Model\Validator;

use nFramework\Exception\InvalidInputException;

class Option extends ValidationStrategy {

  private $options;

  public function __construct($name, array $options) {
    parent::__construct($name);
    $this->options = $options;
  }

  public function validate($input) {
    if (!in_array($input, $this->options)) {
      throw new InvalidInputException($this->name() . ' was an invalid option');
    }
  }

  final protected function getOptions() {
    return $this->options;
  }

}

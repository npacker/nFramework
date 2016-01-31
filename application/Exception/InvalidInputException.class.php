<?php

namespace nFramework\Exception;

use DomainException;

class InvalidInputException extends DomainException {

  public function __construct($message, Exception $previous = null) {
    parent::__construct($message, HttpError::SERVER_ERROR, $previous);
  }

}

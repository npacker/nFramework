<?php

namespace nFramework\Exception;

use BadMethodCallException;

class MethodNotImplementedException extends BadMethodCallException {

  public function __construct($message, Exception $previous = null) {
    parent::__construct($message, HttpError::SERVER_ERROR, $previous);
  }

}

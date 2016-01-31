<?php

namespace nFramework\Exception;

use RuntimeException;
use nFramework\Model\HttpError;

class ResourceNotFoundException extends RuntimeException {

  public function __construct($message, Exception $previous = null) {
    parent::__construct($message, HttpError::NOT_FOUND, $previous);
  }

}

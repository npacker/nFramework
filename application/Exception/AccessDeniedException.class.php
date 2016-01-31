<?php

namespace nFramework\Exception;

use RuntimeException;

class AccessDeniedException extends RuntimeException {

  public function __construct($message, Exception $previous = null) {
    parent::__construct($message, HttpError::ACCESS_DENIED, $previous);
  }

}

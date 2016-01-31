<?php

namespace nFramework\Exception;

use RuntimeException;
use nFramework\Model\HttpError;

class FileNotFoundException extends RuntimeException {

  public function __construct($message, Exception $previous = null) {
    parent::__construct($message, HttpError::SERVER_ERROR, $previous);
  }

}

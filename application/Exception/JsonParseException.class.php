<?php

namespace nFramework\Exception;

use RuntimeException;

class JsonParseException extends RuntimeException {

  public function __construct($message, Exception $previous = null) {
    parent::__construct($message, HttpError::ServerError, $previous);
  }

}

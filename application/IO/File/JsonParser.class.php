<?php

namespace nFramework\IO\File;

final class JsonParser {

  private $inputStream;

  public function __construct($inputStream) {
    $this->inputStream = $inputStream;
  }

  public function readArray() {
    return $this->read(true);
  }

  public function readObject() {
    return $this->read();
  }

  private function read($assoc = false) {
    $json = json_decode($this->inputStream, $assoc);
    
    if (json_last_error() !== \JSON_ERROR_NONE) {
      throw new JsonParseException($this->getLastErrorMessage());
    }

    return $json;
  }

  private function getLastErrorMessage() {
    if (function_exists('json_last_error_msg')) {
      return json_last_error_msg();
    }

    switch (json_last_error()) {
    case \JSON_ERROR_NONE:
      return 'No error has occurred';
    case \JSON_ERROR_DEPTH:
      return 'The maximum stack depth has been exceeded';
    case \JSON_ERROR_STATE_MISMATCH:
      return 'Invalid or malformed JSON';
    case \JSON_ERROR_CTRL_CHAR:
      return 'Control character error, possibly incorrectly encoded';
    case \JSON_ERROR_SYNTAX:
      return 'Syntax error';
    case \JSON_ERROR_UTF8:
      return 'Malformed UTF-8 characters, possibly incorrectly encoded';
    default:
      return 'Unknown error';
    }
  }

}

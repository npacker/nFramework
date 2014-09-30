<?php

class HttpErrorModel extends Model {

  public function __construct() {
    parent::__construct();
  }

  public function find($code, $message, $requestUri) {
    $httpError = new HttpError($code, $requestUri);

    return $httpError;
  }

}
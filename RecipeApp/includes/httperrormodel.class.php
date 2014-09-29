<?php

class HttpErrorModel extends Model {

  public function __construct() {
    parent::__construct();
  }

  public function find($code, $message) {
    $request = new HttpRequest(Request::server('REQUEST_URI'));
    $httpError = new HttpError($code, $request->getUri());

    return $httpError;
  }

}
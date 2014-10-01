<?php

class HttpErrorModel extends Model {

  public function __construct() {}

  public function find($code, $requestUri, $message) {
    switch($code) {
      case HttpError::HTTP_ERROR_ACCESS_DENIED:
        $realMessage = "Access denied.";
        break;
      case HttpError::HTTP_ERROR_SERVER_ERROR:
        $realMessage = "The server encountered an error: {$message}";
        break;
      default:
        $realMessage = "The page {$requestUri} could not be found.";
    }


    $httpError = new HttpError($code, $requestUri, $realMessage);

    return $httpError;
  }

}

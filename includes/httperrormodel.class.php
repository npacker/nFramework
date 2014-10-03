<?php

class HttpErrorModel extends Model {

  public function __construct() {}

  public function find($code, $requestUri, $message) {
    switch ($code) {
      case HttpError::HTTP_ERROR_ACCESS_DENIED:
        $title = "403: Forbidden";
        $realMessage = "Access denied.";
        break;
      case HttpError::HTTP_ERROR_SERVER_ERROR:
        $title = "500: Internal Server Error";
        $realMessage = "The server encountered an error: {$message}";
        break;
      default:
        $title = "404: Not Found";
        $realMessage = "The page {$requestUri} could not be found.";
    }

    if ($code < 500) {
      $level = 'warn';
    } else {
      $level = 'critical';
    }

    return new HttpError($title, $code, $requestUri, $realMessage, $level);
  }

}
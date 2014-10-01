<?php

class HttpError extends Entity {

  const HTTP_ERROR_NOT_FOUND = 404;
  const HTTP_ERROR_ACCESS_DENIED = 403;
  const HTTP_ERROR_SERVER_ERROR = 500;

  protected $code;
  protected $requestUrl;
  protected $message;

  public function __construct($code, $requestUrl, $message) {
    $this->code = $code;
    $this->requestUrl = $requestUrl;
    $this->message = $message;
    $this->setTitle();
  }

  public function getCode() {
    return $this->code;
  }

  public function getRequestUrl() {
    return $this->requestUrl;
  }

  public function getMessage() {
    return $this->message;
  }

  protected function setTitle() {
    switch($this->code) {
      case self::HTTP_ERROR_ACCESS_DENIED:
        $this->title = "403: Forbidden";
        break;
      case self::HTTP_ERROR_SERVER_ERROR:
        $this->title = "500: Internal Server Error";
        break;
      default:
        $this->title = "404: Not Found";
    }
  }

}
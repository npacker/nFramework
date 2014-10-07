<?php

class HttpError extends Entity {

  const HTTP_ERROR_NOT_FOUND = 404;

  const HTTP_ERROR_ACCESS_DENIED = 403;

  const HTTP_ERROR_SERVER_ERROR = 500;

  protected $code;

  protected $requestUrl;

  protected $message;

  protected $level;

  public function __construct($title, $code, $requestUrl, $message, $level) {
    $this->title = $title;
    $this->code = $code;
    $this->requestUrl = $requestUrl;
    $this->message = $message;
    $this->level = $level;
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

}
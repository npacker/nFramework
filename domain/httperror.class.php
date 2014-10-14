<?php

class HttpError extends DomainObject {

  const HTTP_ERROR_BAD_REQUEST = 400;

  const HTTP_ERROR_UNAUTHORIZED = 401;

  const HTTP_ERROR_ACCESS_DENIED = 403;

  const HTTP_ERROR_NOT_FOUND = 404;

  const HTTP_ERROR_METHOD_NOT_ALLOWED = 405;

  const HTTP_ERROR_NOT_ACCEPTABLE = 406;

  const HTTP_ERROR_PROXY_AUTH_REQUIRED = 407;

  const HTTP_ERROR_REQUEST_TIMEOUT = 408;

  const HTTP_ERROR_CONFLICT = 409;

  const HTTP_ERROR_GONE = 410;

  const HTTP_ERROR_LENGTH_REQUIRED = 411;

  const HTTP_ERROR_PRECONDITION_FAILED = 412;

  const HTTP_ERROR_REQUEST_ENTITY_TOO_LARGE = 413;

  const HTTP_ERROR_REQUEST_URI_TOO_LONG = 414;

  const HTTP_ERROR_UNSUPPORTED_MEDIA_TYPE = 415;

  const HTTP_ERROR_REQUEST_RANGE_NOT_SATISFIABLE = 416;

  const HTTP_ERROR_EXPECTATION_FAILED = 417;

  const HTTP_ERROR_SERVER_ERROR = 500;

  const HTTP_ERROR_NOT_IMPLEMENTED = 501;

  const HTTP_ERROR_BAD_GATEWAY = 502;

  const HTTP_ERROR_SERVICE_UNAVAILABLE = 503;

  const HTTP_ERROR_GATEWAY_TIMEOUT = 504;

  const HTTP_ERROR_HTTP_VERSION_NOT_SUPPORTED = 505;

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
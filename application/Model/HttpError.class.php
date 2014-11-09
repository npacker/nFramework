<?php

namespace nFramework\Model;

use Exception;
use nFramework\Exception\AccessDeniedException;
use nFramework\Exception\ResourceNotFoundException;

class HttpError extends DomainObject {

  const BAD_REQUEST = 400;

  const UNAUTHORIZED = 401;

  const ACCESS_DENIED = 403;

  const NOT_FOUND = 404;

  const METHOD_NOT_ALLOWED = 405;

  const NOT_ACCEPTABLE = 406;

  const PROXY_AUTHENTICATION_REQUIRED = 407;

  const REQUEST_TIMEOUT = 408;

  const CONFLICT = 409;

  const GONE = 410;

  const LENGTH_REQUIRED = 411;

  const PRECONDITION_FAILED = 412;

  const REQUEST_ENTITY_TOO_LARGE = 413;

  const REQUEST_URI_TOO_LONG = 414;

  const UNSUPPORTED_MEDIA_TYPE = 415;

  const REQUEST_RANGE_NOT_SATISFIABLE = 416;

  const EXPECTATION_FAILED = 417;

  const SERVER_ERROR = 500;

  const NOT_IMPLEMENTED = 501;

  const BAD_GATEWAY = 502;

  const SERVICE_UNAVAILABLE = 503;

  const GATEWAY_TIMEOUT = 504;

  const HTTP_VERSION_NOT_SUPPORTED = 505;

  protected $code;

  protected $level;

  protected $message;

  protected $uri;

  protected $title;

  public static function code(Exception $e) {
    if ($e instanceof ResourceNotFoundException) {
      return self::NOT_FOUND;
    } else if ($e instanceof AccessDeniedException) {
      return self::ACCESS_DENIED;
    } else {
      return self::SERVER_ERROR;
    }
  }

  public function __construct(array $data = array()) {
    if (isset($data['title'])) {
      $this->title = $data['title'];
    }

    if (isset($data['code'])) {
      $this->code = $data['code'];
    }

    if (isset($data['uri'])) {
      $this->uri = $data['uri'];
    }

    if (isset($data['message'])) {
      $this->message = $data['message'];
    }

    if (isset($data['level'])) {
      $this->level = $data['level'];
    }
  }

  public function getCode() {
    return $this->code;
  }

  public function getLevel() {
    return $this->level;
  }

  public function getMessage() {
    return $this->message;
  }

  public function getUri() {
    return $this->uri;
  }

  public function getTitle() {
    return $this->title;
  }

}
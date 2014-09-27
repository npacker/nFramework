<?php

define('HTTP_ERROR_NOT_FOUND', 404);

define('HTTP_ERROR_ACCESS_DENIED', 403);

define('HTTP_ERROR_SERVER_ERROR', 500);

class HttpError {

	protected $code;
	protected $requestUrl;

	public function __construct($code, $requestUrl) {
	  $this->code = $code;
	  $this->requestUrl = $requestUrl;
	}

	public function getCode() {
		return $this->code;
	}

	public function getRequestUrl() {
		return $this->requestUrl;
	}

}
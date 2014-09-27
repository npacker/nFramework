<?php

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
<?php

class HttpError extends Base {

	protected $code;
	protected $requestUrl;

	public function __construct($code, $requestUrl) {

	}

	public function getCode() {
		return $this->code;
	}

	public function getRequestUrl() {
		return $this->requestUrl;
	}

}
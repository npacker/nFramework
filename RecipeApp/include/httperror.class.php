<?php

class HttpError extends Entity {

	protected $code;
	protected $requestUrl;
	protected $message;

	public function __construct($code, $requestUrl, $message='') {
	  $this->code = $code;
	  $this->requestUrl = $requestUrl;
	  $this->setMessage($message);
	}

	public function getCode() {
		return $this->code;
	}

	public function getRequestUrl() {
		return $this->requestUrl;
	}

	protected function setMessage($message) {
		switch($this->code) {
		  case HTTP_ERROR_ACCESS_DENIED:
		  	$this->message = "Access denied.";
		  	break;
		  case HTTP_ERROR_SERVER_ERROR:
		  	$this->message = "The server encountered an error";
		  	break;
		  default:
		   $this->message = "The page {$this->requestUrl} could not be found.";
		}
	}

}
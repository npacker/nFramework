<?php

class HttpException extends Exception {

	public function __construct(HttpError $error) {
		$message = "Error {$error->getCode()}. The requested page {$error->getRequestUrl()} could not be loaded."';
		parent::__construct($message);
	}

}
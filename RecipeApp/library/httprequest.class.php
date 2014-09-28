<?php

class HttpRequest {

	protected $uri;
	protected $params;
	protected $query;

	public function __construct($uri) {
		$this->uri = str_replace(base_path(), '', $uri);
		$this->parseUrl();
	}

	public function getUri() {
		return $this->uri;
	}

	public function getParams() {
		return $this->params;
	}

	public function getQuery() {
	 return $this->query;
	}

	protected function parseUrl() {
		$this->params = parse_path(array_shift(explode('?', $this->uri)));
		$this->query = parse_query(array_pop(explode('?', $this->uri)));
	}

}
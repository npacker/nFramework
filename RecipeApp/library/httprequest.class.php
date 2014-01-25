<?php

class HttpRequest extends Base {

	protected $uri;
	protected $controller;
	protected $action;
	protected $args;

	public function __construct($uri) {
		$this->uri = str_replace(base_path(), '', $uri);
		$this->parseUrl();
	}

	public function getUri() {
		return $this->uri;
	}

	public function getController() {
		return $this->controller;
	}

	public function getAction() {
		return $this->action;
	}

	public function getArgs() {
		return $this->args;
	}

	protected function parseUrl() {
		$params = parse_path($this->uri);
		$this->controller = array_shift($params);
		$this->action = array_shift($params);
		$this->args = $params;
	}

}
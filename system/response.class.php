<?php

class Response {

  protected $header;

  protected $body;

  public function send() {
    ob_start();
    header($this->header);
    echo $this->body;
    ob_end_flush();
    exit();
  }

  public function setHeader($header) {
    $this->header = $header;
  }

  public function setBody($body) {
    $this->body = $body;
  }

}
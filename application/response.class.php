<?php

namespace nFramework\Application;

class Response {

  protected $locationHeader;

  protected $responseHeader;

  protected $content;

  public function send() {
    ob_start();

    if (isset($this->locationHeader)) {
      header('Location: ' . $this->locationHeader);
      exit();
    }

    header($this->responseHeader);
    echo $this->content;
    ob_end_flush();
    exit();
  }

  public function setLocationHeader($header) {
    $this->locationHeader = $header;
  }

  public function setResponseHeader($header) {
    $this->responseHeader = $header;
  }

  public function setContent($content) {
    $this->content = $content;
  }

}
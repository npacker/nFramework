<?php

class Response {
  protected $header;
  protected $template;

  public function send() {
    ob_start();
    header($this->header);
    echo $this->template->parse();
    ob_end_flush();
    exit();
  }

  public function setHeader($header) {
    $this->header = $header;
  }

  public function setTemplate(Template $template) {
    $this->template = $template;
  }
}
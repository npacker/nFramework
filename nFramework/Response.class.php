<?php
namespace nFramework;

class Response {

  protected $redirect;

  protected $status;

  protected $content;

  public function __construct($content = null) {
   $this->content = $content;
  }

  public function send() {
    ob_start();

    if (isset($this->redirect)) {
      header('Location: ' . $this->redirect);
      exit();
    }

    header($this->status);
    echo $this->content;
    ob_end_flush();
    exit();
  }

  public function content($content) {
    $this->content= $content;

    return $this;
  }

  public function redirect($location) {
    $this->redirect = $location;

    return $this;
  }

  public function status($status) {
    $this->status = $status;

    return $this;
  }

  public function __isset($field) {
   return isset($this->$field);
  }

}
<?php

class Response {
  protected $header;
  protected $data;

  public function send($data) {
    
  }
  
  protected function processPage($page_title, $page, $page_top, $page_bottom) {
    ob_start();
  
    include ROOT . DS . 'templates' . DS . 'html.tpl.php';
  
    return ob_get_clean();
  }
}
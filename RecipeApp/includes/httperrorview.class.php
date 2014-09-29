<?php

class HttpErrorView extends View {
  
  protected function processTemplate() {
    extract($this->variables);
    
    ob_start();
    
    include ROOT . DS . 'templates' . DS . 'httperror' . DS . 'page.tpl.php';
    
    return ob_get_clean();
  }
  
}
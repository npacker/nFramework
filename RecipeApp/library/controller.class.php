<?php

abstract class Controller {
  protected $model;
  protected $template;
  protected $variables = array();

  public function __destruct() {
    $this->render();
  }

  protected function getControllerName() {
    return str_replace('controller', '', strtolower(get_class($this)));
  }

  protected function prepare($data) {
    if (is_object($data)) {
      $properties = $data->getProperites();
    } else if (is_array($data)) {
      $properties = $data;
    }

    foreach ($properties as $key => $value) {
      $this->set($key, $value);
    }
  }
  
  protected function processTemplate() {   
    extract($this->variables);
    
    ob_start();
  
    include $this->template;
  
    return ob_get_clean();
  }

  protected function set($key, $value) {
    $this->variables[$key] = $value;
  }
  
  protected function setTemplate($template) {
    $this->template = ROOT . DS . 'templates' . DS . "{$this->getControllerName()}" . DS . "{$template}.tpl.php";
  }
  
  protected function render() {
    $page_title = $this->variables['title'];
    $page = $this->processTemplate();
    
    ob_start();
  
    include ROOT . DS . 'templates' . DS . 'html.tpl.php';
    
    print ob_get_clean();
  }
}
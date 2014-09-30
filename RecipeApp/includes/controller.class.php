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

  protected function prepare(Entity $entity) {
    $properties = $entity->getProperites();

    foreach ($properties as $key => $value) {
      $this->set($key, $value);
    }
  }
  
  protected function processTemplate($template) {   
    extract($this->variables);
    
    ob_start();
  
    include $template;
  
    return ob_get_clean();
  }

  public function set($key, $value) {
    $this->variables[$key] = $value;
  }
  
  protected function setTemplate($template) {
    $this->template = $template;
  }
  
  protected function render() {
    $template = ROOT . DS . 'templates' . DS . "{$this->getControllerName()}" . DS . "{$this->template}.tpl.php";
    $page = $this->processTemplate($template);
    
    print $this->renderPage($this->variables['title'], $page);
  }
  
  protected function renderPage($page_title, $page) {  
    ob_start();
  
    include ROOT . DS . 'templates' . DS . 'html.tpl.php';
  
    return ob_get_clean();
  }

}
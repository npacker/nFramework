<?php

namespace nFramework\View;

class Template {

  protected $css = array();

  protected $data = array();

  protected $js = array();

  protected $template;

  protected $variables = array();

  public function __construct($template, array $data = array()) {
    $this->processIncludePath($template);
    $this->data = $data;
  }

  public function __isset($key) {
    return isset($this->data[$key]);
  }

  public function addStyle($css) {
    if (is_array($css)) {
      $this->css = array_replace($this->css, $css);
    } else {
      $this->css[$css] = $css;
    }
  }

  public function addScript($js) {
    if (is_array($js)) {
      $this->js = array_replace($this->js, $js);
    } else {
      $this->js[$js] = $js;
    }
  }

  public function getData($key) {
    return array_key_exists($key, $this->data) ? $this->data[$key] : null;
  }

  public function getStyle() {
    return $this->css;
  }

  public function getScript() {
    return $this->js;
  }

  public function parse() {
    $this->parseData($this->data);
    $this->parseStyles($this->css);
    $this->parseScripts($this->js);
    extract($this->variables);
    ob_start();
    include $this->template;
    return ob_get_clean();
  }

  protected function parseData($data) {
    foreach ($data as $key => $value) {
      $processedKey = trim($key, "*\0");

      if ($value instanceof Template) {
        $processedValue = $value->parse();
        $this->addStyle($value->getStyle());
        $this->addScript($value->getScript());
      } else {
        $processedValue = $value;
      }

      $this->setVariable($processedKey, $processedValue);
    }
  }

  protected function parseStyles($css) {
    $basePath = base_path();
    $baseUrl = base_url();
    $style = '';
    $format = "<link rel=\"stylesheet\" href=\"http://%s%s/css/%s.css\" type=\"text/css\" media=\"screen\">\n";

    foreach ($css as $stylesheet) {
      $stylesheet = str_replace('/', DS, $stylesheet);
      $style .= sprintf($format, $baseUrl, $basePath, $stylesheet);
    }

    $this->setVariable('style', $style);
  }

  protected function parseScripts($js) {
    $basePath = base_path();
    $baseUrl = base_url();
    $script = '';
    $format = "<script type=\"text/javascript\" src=\"http://%s%s/js/%s.js\"></script>\n";

    foreach ($js as $javascript) {
      $javascript = str_replace('/', DS, $javascript);
      $script .= sprintf($format, $baseUrl, $basePath, $javascript);
    }

    $this->setVariable('script', $script);
  }

  protected function processIncludePath($template) {
    $template = str_replace('/', DS, $template);
    $this->template = ROOT . DS . 'templates' . DS . $template . '.tpl.php';
  }

  protected function setVariable($key, $value) {
    $this->variables[$key] = $value;
  }

}
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

  public function __get($key) {
    return (isset($this->data[$key])) ? $this->data[$key] : null;
  }

  public function __isset($key) {
    return isset($this->data[$key]);
  }

  public function __set($key, $value) {
    $this->data[$key] = $value;

    return $this;
  }

  public function addStyle($css) {
    if (is_array($css)) {
      $this->css = array_replace($this->css, $css);
    } else {
      $this->css[$css] = $css;
    }

    return $this;
  }

  public function addScript($js) {
    if (is_array($js)) {
      $this->js = array_replace($this->js, $js);
    } else {
      $this->js[$js] = $js;
    }

    return $this;
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
    $format = "<link rel=\"stylesheet\" href=\"%s%s/public/css/%s.css\" type=\"text/css\" media=\"screen\">\n";

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
    $format = "<script type=\"text/javascript\" src=\"%s%s/public/js/%s.js\"></script>\n";

    foreach ($js as $javascript) {
      $javascript = str_replace('/', DS, $javascript);
      $script .= sprintf($format, $baseUrl, $basePath, $javascript);
    }

    $this->setVariable('script', $script);
  }

  protected function processIncludePath($template) {
    $file = explode(':', $template);
    $namespace = implode(DS, array_splice($file, 0, 2));
    $file = implode(DS, $file);

    $this->template = ROOT . DS . 'packages' . DS . $namespace . DS . 'templates' . DS . $file . '.tpl.php';
  }

  protected function setVariable($key, $value) {
    $this->variables[$key] = $value;
  }

}
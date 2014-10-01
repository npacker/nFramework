<?php

class Template {

  protected $css = array();
  protected $data;
  protected $js = array();
  protected $template;
  protected $variables = array();

  /**
   *
   * @param string $include
   * @param $variables an associative array or object
   */
  public function __construct($template, $data = array()) {
    $this->processIncludePath($template);
    $this->data = $data;
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

  public function getStyle() {
    return $this->css;
  }

  public function getScript() {
    return $this->js;
  }

  public function parse() {
    $this->processData($this->data);
    $this->parseStyles($this->css);
    $this->parseScripts($this->js);
    extract($this->variables);
    ob_start();

    include $this->template;

    return ob_get_clean();
  }

  protected function parseStyles($css) {
    $basePath = base_path();
    $baseUrl = base_url();
    $style = '';

    foreach ($css as $stylesheet) {
      $style .= "<link rel=\"stylesheet\" href=\"http://{$baseUrl}{$basePath}/css/{$stylesheet}.css\" type=\"text/css\" media=\"screen\">\n";
    }

    $this->setVariable('style', $style);
  }

  protected function parseScripts($js) {
    $basePath = base_path();
    $baseUrl = base_url();
    $script = '';

    foreach ($js as $javascript) {
      $script .= "<script type=\"text/javascript\" src=\"http://{$baseUrl}{$basePath}/js/{$javascript}.js\"></script>\n";
    }

    $this->setVariable('script', $script);
  }

  protected function processData($data) {
    $variables = (array) $data;

    foreach ($variables as $key => $value) {
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

  protected function processIncludePath($template) {
    $template = str_replace(DS, '/', $template);
    $this->template = ROOT . DS . 'templates' . DS . $template . '.tpl.php';
  }

  protected function setVariable($key, $value) {
    $this->variables[$key] = $value;
  }

}
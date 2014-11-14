<?php

namespace nFramework\View;

final class Template {

  private $css = array();

  private $data = array();

  private $js = array();

  private $template;

  private $variables = array();

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

  public function render() {
    $this->parseData($this->data);
    $this->parseStyles($this->css);
    $this->parseScripts($this->js);

    extract($this->variables);

    ob_start();
    include $this->template;
    return ob_get_clean();
  }

  private function createAssetPath($asset, $type) {
    if (preg_match('/^http:\/\/.+$/', $asset)) {
      return $asset;
    }

    $filename = $asset;
    $namespace = null;
    $this->extractAssetNamespace($filename, $namespace, '/');

    if (strpos($asset, '::') === 0) {
      return '/application/resources/' . $type . '/' . $filename . '.' . $type;
    } else {
      return '/public/' . $type . '/' . $filename . '.' . $type;
    }
  }

  private function extractAssetNamespace(&$asset, &$namespace, $separator = DS) {
    $parts = explode(':', $asset);
    $namespace = implode($separator, array_splice($parts, 0, 2));
    $asset = implode($separator, $parts);
  }

  private function parseData($data) {
    foreach ($data as $key => $value) {
      $processedKey = trim($key, "*\0");

      if ($value instanceof Template) {
        $processedValue = $value->render();
        $this->addStyle($value->getStyle());
        $this->addScript($value->getScript());
      } else {
        $processedValue = $value;
      }

      $this->setVariable($processedKey, $processedValue);
    }
  }

  private function parseStyles($css) {
    $basePath = base_path();
    $baseUrl = base_url();
    $style = '';
    $format = "<link rel=\"stylesheet\" href=\"%s%s%s\" type=\"text/css\" media=\"screen\">\n";

    foreach ($css as $stylesheet) {
      $stylesheet = $this->createAssetPath($stylesheet, 'css');
      $style .= sprintf($format, $baseUrl, $basePath, $stylesheet);
    }

    $this->setVariable('style', $style);
  }

  private function parseScripts($js) {
    $basePath = base_path();
    $baseUrl = base_url();
    $script = '';
    $format = "<script type=\"text/javascript\" src=\"%s%s%s\"></script>\n";

    foreach ($js as $javascript) {
      $javascript = $this->createAssetPath($javascript, 'js');
      $script .= sprintf($format, $baseUrl, $basePath, $javascript);
    }

    $this->setVariable('script', $script);
  }

  private function processIncludePath($template) {
    $filename = $template;
    $namespace = null;
    $this->extractAssetNamespace($filename, $namespace);

    if (strpos($template, '::') === 0) {
      $file = ROOT . DS . 'application' . DS . 'templates' . DS . $filename . '.tpl.php';
    } else {
      $file = ROOT . DS . 'packages' . DS . $namespace . DS . 'templates' . DS . $filename . '.tpl.php';
    }

    $this->template = $file;
  }

  private function setVariable($key, $value) {
    $this->variables[$key] = $value;
  }

}

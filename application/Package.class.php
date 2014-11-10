<?php

namespace nFramework;

use RuntimeException;
use nFramework\Exception\FileNotFoundException;

final class Package {

  private $config;

  private $package;

  private $vendor;

  public function __construct($name) {
    $parts = explode(':', $name);
    $this->package = array_pop($parts);
    $this->vendor = array_pop($parts);
  }

  public function getConfig() {
    if (empty($this->config)) {
      $this->config = $this->loadConfig($this->vendor, $this->package);
    }

    return $this->config;
  }

  private function loadConfig($vendor, $package) {
    $dir = $vendor . DS . $package;
    $path = ROOT . DS . 'packages' . DS . $dir . DS . 'config' . DS . 'paths.json';

    if (!file_exists($path)) {
      throw new FileNotFoundException('Paths configuration file could not be loaded.');
    } else if (!is_readable($path)) {
      throw new RuntimeException('Paths configuration file was not readable');
    }

    $contents = file_get_contents($path);
    $json = json_decode($contents);

    if ($json == null) {
      throw new RuntimeException(json_last_error_msg());
    }

    return $json;
  }

}

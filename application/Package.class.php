<?php

namespace nFramework;

use nFramework\IO\File\FileReader;
use nFramework\IO\File\JsonParser;

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
    $path = ROOT . DS . 'packages' . DS . $vendor . DS . $package . DS . 'config' . DS . 'paths.json';
    $fileReader = new FileReader($path);
    $jsonParser = new JsonParser($fileReader->read());

    return $jsonParser->readObject();
  }

}

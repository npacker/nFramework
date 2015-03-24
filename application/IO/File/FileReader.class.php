<?php

namespace nFramework\IO\File;

use nFramework\Exception\FileNotFoundException;

final class FileReader {

  private $path;

  public function __construct($path) {
    $this->path = $path;

    if (!is_readable($path)) {
      throw new FileNotFoundException('File at ' . $this->path . ' was not readable.');
    }
  }

  public function read() {
    return file_get_contents($this->path);
  }

}

<?php

namespace nFramework\Model;

use Iterator;

class DomainObjectCollection implements Iterator {

  protected $data;

  protected $factory;

  protected $size;

  private $key = 0;

  private $objects = array();

  public function __construct(array $data, DomainObjectFactory $factory) {
    $this->data = $data;
    $this->factory = $factory;
    $this->size = count($data);
  }

  public function current() {
    if (!isset($this->data[$this->key])) {
      return null;
    }

    if (!isset($this->objects[$this->key])) {
      $this->objects[$this->key] = $this->factory->create(
        $this->data[$this->key]);
    }

    return $this->objects[$this->key];
  }

  public function key() {
    return $this->key;
  }

  public function next() {
    $this->key++;
  }

  public function rewind() {
    $this->key = 0;
  }

  public function valid() {
    return ($this->key > -1 && $this->key < $this->size);
  }

}

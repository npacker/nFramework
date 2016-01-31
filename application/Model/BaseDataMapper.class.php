<?php

namespace nFramework\Model;

use nFramework\Database\Database;

abstract class BaseDataMapper implements DataMapper {

  protected $database;

  final public function __construct(Database $database) {
    $this->database = $database;
  }

  final public function attributes() {
    return $this->attributes;
  }

  abstract public function create(DomainObject $object);

  abstract public function delete(DomainObject $object);

  abstract public function find(DomainObject $object);

  abstract public function findAll();

  final public function relation() {
    return $this->relation;
  }

  abstract public function update(DomainObject $object);

  protected function columnsPrefixed() {
    return array_map(function($element) {
      return "{$this->relation()}.{$element}";
    }, $this->attributes());
  }

  protected function columnsUpdatePlaceholders() {
    return array_map(function($element) {
      return "{$element} = ?";
    }, $this->attributes());
  }

}

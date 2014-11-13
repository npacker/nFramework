<?php

namespace nFramework\Model;

use nFramework\Database\MySqlDatabase;

abstract class DataMapper implements iDataMapper {

  protected $database;

  public function __construct() {
    global $databases;

    $this->database = MySqlDatabase::instance(
      $databases['default']['hostname'],
      $databases['default']['database'],
      $databases['default']['username'],
      $databases['default']['password']
    );
  }

  abstract public function create(DomainObject $object);

  abstract public function delete(DomainObject $object);

  abstract public function find(DomainObject $object);

  abstract public function findAll();

  abstract public function update(DomainObject $object);

}
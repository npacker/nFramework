<?php

abstract class DataMapper implements iDataMapper {

  protected $database;

  public function __construct() {
    global $databases;

    $hostname = $databases['default']['hostname'];
    $database = $databases['default']['database'];
    $username = $databases['default']['username'];
    $password = $databases['default']['password'];

    $this->database = MySqlDatabase::instance(
      $hostname,
      $database,
      $username,
      $password);
  }

  abstract public function create(DomainObject $object);

  abstract public function delete(DomainObject $object);

  abstract public function find(DomainObject $object);

  abstract public function findAll();

  abstract public function update(DomainObject $object);

}
<?php

abstract class Model {

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

}
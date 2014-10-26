<?php

namespace nFramework\Application\Model;

abstract class DomainObject {

  abstract public function __construct(array $data = array());

  public function getProperites() {
    return get_object_vars($this);
  }

}
<?php

use nFramework\Application\Model\DomainObjectFactory;

class PageFactory extends DomainObjectFactory {

  public function create(array $data) {
    return new Page($data);
  }

}
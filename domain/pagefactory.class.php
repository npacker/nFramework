<?php

class PageFactory extends DomainObjectFactory {

  public function create(array $data) {
    return new Page($data);
  }

}
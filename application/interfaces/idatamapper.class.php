<?php

namespace nFramework\Application\Model\Interfaces;

use nFramework\Application\Model\DomainObject;

interface iDataMapper {

  public function create(DomainObject $object);

  public function delete(DomainObject $object);

  public function find(DomainObject $object);

  public function findAll();

  public function update(DomainObject $object);

}
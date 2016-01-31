<?php

namespace nFramework\Model;

interface DataMapper {

  public function attributes();

  public function create(DomainObject $object);

  public function delete(DomainObject $object);

  public function find(DomainObject $object);

  public function findAll();

  public function relation();

  public function update(DomainObject $object);

}

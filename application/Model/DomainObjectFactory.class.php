<?php

namespace nFramework\Model;

abstract class DomainObjectFactory implements iDomainObjectFactory {

  abstract public function create(array $data);

}
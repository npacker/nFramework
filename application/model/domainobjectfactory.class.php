<?php

namespace nFramework\Application\Model;

use nFramework\Application\Model\Interfaces\iDomainObjectFactory;

abstract class DomainObjectFactory implements iDomainObjectFactory {

  abstract public function create(array $data);

}
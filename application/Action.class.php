<?php

namespace nFramework;

abstract class Action {

  private $application;

  final public function __construct(Application $application = null) {
    $this->application = $application;
  }

  abstract public function execute(Context $context);

}

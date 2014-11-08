<?php

namespace nFramework;

abstract class Action {

  private $application;

  public function __construct(Application $application) {
    $this->application = $application;
  }

  abstract public function execute(Context $context);

}
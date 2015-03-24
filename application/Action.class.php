<?php

namespace nFramework;

abstract class Action {

  private $application;

  abstract public function execute(Context $context);

}

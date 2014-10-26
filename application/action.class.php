<?php

namespace nFramework\Application;

abstract class Action {

  abstract public function execute(ActionContext $context);

}
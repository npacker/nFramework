<?php

abstract class Action implements iAction {

  abstract public function execute(ActionContext $context);

}
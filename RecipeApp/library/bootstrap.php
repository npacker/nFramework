<?php

require_once (ROOT . DS . 'library' . DS . 'config.php');
require_once (ROOT . DS . 'library' . DS . 'autoload.php');
require_once (ROOT . DS . 'library' . DS . 'router.php');

function bootstrapFull() {
	pathInit();
}

bootstrapFull();
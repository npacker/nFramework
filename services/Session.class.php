<?php

use nFramework\ActionContext;

class Session {

  public function start() {
    if (isset($_SESSION)) {
      return;
    }

    if (!session_start()) {
      throw new RuntimeException("Failed to start a valid session.");
    }
  }

  public function valid() {
    if (!empty($_SESSION['USERNAME'])) {
      return true;
    }

    return false;
  }

  public function validate(ActionContext $context) {
    session_regenerate_id(true);
    $_SESSION['USERNAME'] = $context->get('username');
  }

  public function revalidate() {
    session_regenerate_id(true);
  }

  public function destroy() {
    session_regenerate_id(true);
    session_destroy();
  }

}
<?php

class Session {

  public function __construct() {

  }

  public function start() {
    if (isset($_SESSION)) {
      return;
    }

    if (!session_start()) {
      throw new RuntimeException("Failed to start a valid session.");
    }
  }

  public function valid() {
    if (!empty($_SESSION['VALID'])) {
      return $_SESSION['VALID'];
    }

    return false;
  }

  public function validate() {
    session_regenerate_id(TRUE);
    $_SESSION['VALID'] = true;
  }

  public function revalidate() {
    session_regenerate_id(TRUE);
  }

  public function destroy() {
    session_regenerate_id(TRUE);
    session_unset();
    $_SESSION = array();
    session_destroy();
    logout_redirect();
  }

}
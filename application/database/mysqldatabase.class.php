<?php

namespace nFramework\Application\Database;

class MySqlDatabase extends Database {

  protected function prefix() {
    return 'mysql';
  }

}
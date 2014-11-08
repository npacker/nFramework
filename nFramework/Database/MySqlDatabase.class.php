<?php

namespace nFramework\Database;

class MySqlDatabase extends Database {

  protected function prefix() {
    return 'mysql';
  }

}
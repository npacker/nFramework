<?php

class Entity {

  protected $title;

  public function getProperites() {
    return get_object_vars($this);
  }

  public function getTitle() {
    return $this->title;
  }

}
<?php

class Page extends DomainObject {

  public $content;

  public $created;

  public $id;

  public $title;

  public function __construct(array $data = array()) {
    if (isset($data['id'])) {
      $this->id = $data['id'];
    }

    if (isset($data['title'])) {
      $this->title = $data['title'];
    }

    if (isset($data['content'])) {
      $this->content = $data['content'];
    }

    if (isset($data['created'])) {
      $this->created = $data['created'];
    }
  }

  public function getContent() {
    return $this->content;
  }

  public function getCreated() {
    return $this->created;
  }

  public function getId() {
    return $this->id;
  }

  public function getTitle() {
    return $this->title;
  }

  public function setContent($contet) {
    $this->content = $content;
  }

  public function setId($id) {
    if (empty($id)) {
      throw new InvalidInputException('Page id is required.');
    } else if (!is_numeric($id)) {
      throw new InvalidInputException('Page id must be numeric');
    }

    $this->id = $id;
  }

  public function setTitle($title) {
    if (empty($title)) {
      throw new InvalidInputException('Page title is required.');
    }

    $this->title = $title;
  }

}
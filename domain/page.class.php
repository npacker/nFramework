<?php

class Page extends DomainObject {

  public $content;

  public $created;

  public $id;

  public $title;

  public function __construct(array $data = array()) {
    if (isset($data['id'])) {
      $this->setId($data['id']);
    }

    if (isset($data['title'])) {
      $this->setTitle($data['title']);
    }

    if (isset($data['content'])) {
      $this->setContent($data['content']);
    }

    if (isset($data['created'])) {
      $this->setCreated($data['created']);
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

  public function setContent($content) {
    $this->content = $content;
  }

  public function setCreated($created) {
    if (empty($created)) {
      throw new InvalidInputException('Page created timestamp is required.');
    } else if (!preg_match("/^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}$/", $created)) {
      throw new InvalidInputException('Page created timestamp is in an invalid format.');
    }
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
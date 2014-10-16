<?php

class PageViewAction extends Action {

  public function execute(ActionContext $context) {
    $mapper = new PageMapper();
    $id = $context->get('path_argument');

    if ($id == 'all') {
      $pages = $mapper->findAll();

      $data = array(
        'title' => 'All Content',
        'content' => new Template(
          'page/index',
          array(
            'pages' => $pages,
            'base_url' => base_url(),
            'base_path' => base_path())),
        'template' => 'html');
    } else {
      $page = new Page();
      $page->setId($id);
      $mapper->find($page);

      $data = array(
        'title' => $page->getTitle(),
        'content' => new Template('page/view', (array) $page),
        'template' => 'html');
    }

    return $data;
  }

}
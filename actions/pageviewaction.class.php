<?php

class PageViewAction extends Action {

  public function execute(ActionContext $context) {
    $mapper = new PageMapper();
    $id = $context->get('path_argument');

    if ($id == 'all') {
      $pages = $mapper->findAll();

      $variables['pages'] = $pages;
      $variables['base_url'] = base_url();
      $variables['base_path'] = base_path();

      $data['title'] = 'All Content';
      $data['content'] = new Template('page/index', $variables);
      $data['template'] = 'html';
    } else {
      $page = new Page();
      $page->setId($id);
      $mapper->find($page);

      $data['title'] = $page->getTitle();
      $data['content'] = new Template('page/view', (array) $page);
      $data['template'] = 'html';
    }

    return $data;
  }

}
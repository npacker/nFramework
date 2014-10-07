<?php

class PageViewAction extends Action implements iAction {

  public function execute(ActionContext $context) {
    $model = new Page();
    $id = $context->get('path_argument');

    if ($id == 'all') {
      $pages = $model->all();

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
      $page = $model->find($id);

      if (empty($page)) {
        throw new Exception("The page could not be found.");
      }

      $data = array(
        'title' => $page['title'],
        'content' => new Template('page/view', $page),
        'template' => 'html');
    }

    return $data;
  }

}
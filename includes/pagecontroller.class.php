<?php

class PageController extends Controller {

  public function __construct() {
    $this->model = new PageModel();
  }

  public function view(array $args = array()) {
    $id = $args['path_argument'];

    if ($id == 'all') {
      return $this->all($args);
    }

    $page = $this->model->find($id);

    if (empty($page)) {
      throw new Exception("The page could not be found.");
    }

    $data['title'] = $page['title'];
    $data['content'] = new Template('page/view', $page);
    $data['template'] = 'html';

    return $data;
  }

  public function all(array $args = array()) {
    $pages = $this->model->all();

    $data['title'] = 'All Content';
    $data['content'] = new Template(
      'page/index',
      array(
        'pages' => $pages,
        'base_url' => base_url(),
        'base_path' => base_path()));
    $data['template'] = 'html';

    return $data;
  }

  public function edit(array $args = array()) {
     $id = $args['path_argument'];

     $page = $this->model->find($id);

     if (empty($page)) {
       throw new Exception("The page could not be found.");
     }

     $data['title'] = $page['title'];
     $data['content'] = new Template('page/edit', $page);
     $data['template'] = 'html';

     return $data;
  }

}
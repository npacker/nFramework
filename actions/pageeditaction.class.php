<?php

class PageEditAction extends Action {

  public function execute(ActionContext $context) {
    $model = new PageMapper();
    $id = $context->get('path_argument');
    $title = $context->get('title');
    $content = $context->get('content');

    if (isset($title) && isset($content)) {
      $model->update($id, $title, $content);
    }

    $page = $model->find($id);

    if (empty($page)) {
      throw new Exception("The page could not be found.");
    }

    $page['action'] = 'http://' . base_url() . base_path() . '/page/edit/' . $id;

    $template = new Template('page/edit', $page);
    $template->addScript(array('jquery','ckeditor/ckeditor','editor'));

    $data = array(
      'title' => "Editing page <em>{$page['title']}</em>",
      'content' => $template,
      'template' => 'html');

    return $data;
  }

}
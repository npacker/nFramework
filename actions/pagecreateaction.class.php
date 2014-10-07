<?php

class PageCreateAction extends Action implements iAction {

  public function execute(ActionContext $context) {
    $model = new Page();
    $title = $context->get('title');
    $content = $context->get('content');

    if (isset($title) && isset($content)) {
      $id = $model->create($title, $content);
    }

    $action = 'http://' . base_url() . base_path() . '/page/create';

    $template = new Template(
      'page/edit',
      array('title' => '','content' => '','action' => $action));
    $template->addScript(array('jquery','ckeditor/ckeditor','editor'));

    $data = array(
      'title' => 'Create new page',
      'content' => $template,
      'template' => 'html');

    if (isset($id)) {
      $data['location header'] = 'Location: http://' . base_url() . base_path() . "/page/view/{$id}";
    }

    return $data;
  }

}
<?php

use nFramework\Action;
use nFramework\ActionContext;
use nFramework\View\Template;

class PageCreateAction extends Action {

  public function execute(ActionContext $context) {
    $mapper = new PageMapper();
    $page = new Page();
    $title = $context->get('title');
    $content = $context->get('content');

    if (isset($title) && isset($content)) {
      $page->setTitle($title);
      $page->setContent($content);
      $mapper->create($page);

      return array(
        'location' => 'http://' . base_url() . base_path() . '/page/view/' . $page->getId());
    }

    $variables['title'] = '';
    $variables['content'] = '';
    $variables['action'] = 'http://' . base_url() . base_path() . '/page/create';

    $template = new Template('page/edit', $variables);
    $template->addScript(array('jquery', 'ckeditor/ckeditor', 'editor'));

    $data['title'] = 'Create new page';
    $data['content'] = $template;
    $data['template'] = 'html';

    return $data;
  }

}

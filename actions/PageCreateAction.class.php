<?php

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Response;

class PageCreateAction extends Action {

  public function execute(Context $context) {
    $mapper = new PageMapper();
    $page = new Page();
    $response = new Response();
    $title = $context->get('title');
    $content = $context->get('content');

    if (isset($title) && isset($content)) {
      $page->setTitle($title);
      $page->setContent($content);
      $mapper->create($page);

      return $response->redirect('http://' . base_url() . base_path() . '/page/view/' . $page->getId());
    }

    $template = new Template('html', array(
      'title' => 'Create new page',
      'header' => new Template('header', array('base_url' => base_url(), 'base_path' => base_path())),
      'page' => new Template('page/edit', array('title' => '', 'content' => '', 'action' => 'http://' . base_url() . base_path() . '/page/create')),
      'footer' => new Template('footer')
    ));
    $template->addStyle('default');
    $template->addScript(array('default', 'jquery', 'ckeditor/ckeditor', 'editor'));

    return $response->content($template->parse());
  }

}

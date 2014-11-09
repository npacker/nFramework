<?php

namespace Nigel\WebsitePackage;

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

      return $response->redirect(base_url() . base_path() . '/page/' . $page->getId());
    }

    $template = new Template('Nigel:WebsitePackage:html', array(
      'title' => 'Create new page',
      'page' => new Template('Nigel:WebsitePackage:page:edit', array(
        'title' => '',
        'content' => '',
        'action' => base_url() . base_path() . '/page/create'
      ))
    ));
    $template->addStyle('default');
    $template->addScript(array('default', 'jquery', 'ckeditor/ckeditor', 'editor'));

    return $response->content($template->parse());
  }

}
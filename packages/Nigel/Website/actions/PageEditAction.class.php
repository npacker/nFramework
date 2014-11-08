<?php

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Response;

class PageEditAction extends Action {

  public function execute(Context $context) {
    $mapper = new PageMapper();
    $page = new Page();
    $id = $context->get('id');
    $title = $context->get('title');
    $content = $context->get('content');
    $page->setId($id);

    if (isset($title) && isset($content)) {
      $page->setTitle($title);
      $page->setContent($content);
      $mapper->update($page);
    } else {
      $mapper->find($page);
    }

    $title = $page->getTitle();

    if (empty($title)) {
      throw new ResourceNotFoundException('The page could not be found.');
    }

    $variables = (array) $page;
    $variables['action'] = 'http://' . base_url() . base_path() . '/page/' . $id . '/edit';

    $template = new Template('Nigel:Website:html', array(
      'title' => "Editing page <em>{$page->getTitle()}</em>",
      'header' => new Template('Nigel:Website:header', array('base_url' => base_url(), 'base_path' => base_path())),
      'page' => new Template('Nigel:Website:page:edit', $variables),
      'footer' => new Template('Nigel:Website:footer')
    ));
    $template->addStyle('default');
    $template->addScript(array('default', 'jquery', 'ckeditor/ckeditor', 'editor'));

    return new Response($template->parse());
  }

}

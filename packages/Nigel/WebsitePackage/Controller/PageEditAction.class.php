<?php

namespace Nigel\WebsitePackage;

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
    $variables['action'] = base_url() . base_path() . '/page/' . $id . '/edit';

    $template = new Template('Nigel:WebsitePackage:html', array(
      'title' => "Editing page <em>{$page->getTitle()}</em>",
      'page' => new Template('Nigel:WebsitePackage:page:edit', $variables)
    ));
    $template->addStyle('Nigel:WebsitePackage:default');
    $template->addScript(array('Nigel:WebsitePackage:default', 'Nigel:WebsitePackage:jquery', 'Nigel:WebsitePackage:ckeditor:ckeditor', 'Nigel:WebsitePackage:editor'));

    return new Response($template->render());
  }

}

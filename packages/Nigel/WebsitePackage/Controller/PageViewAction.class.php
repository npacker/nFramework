<?php

namespace Nigel\WebsitePackage;

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Response;

class PageViewAction extends Action {

  public function execute(Context $context) {
    $mapper = new PageMapper();
    $id = $context->get('id');

    if ($id == 'all') {
      $pages = $mapper->findAll();

      $title = 'All Content';
      $content = new Template('Nigel:WebsitePackage:page:index', array(
        'pages' => $pages,
        'base_url' => base_url(),
        'base_path' => base_path()
      ));
    } else {
      $page = new Page();
      $page->setId($id);
      $mapper->find($page);

      $title = $page->getTitle();
      $content = new Template('Nigel:WebsitePackage:page:view', (array) $page);
    }

    $template = new Template('Nigel:WebsitePackage:html', array(
      'title' => $title,
      'page' => $content
    ));
    $template->addStyle('Nigel:WebsitePackage:default');
    $template->addScript('Nigel:WebsitePackage:default');

    return new Response($template->parse());
  }

}

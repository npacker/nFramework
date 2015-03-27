<?php

namespace Nigel\WebsitePackage;

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Response;

class PageViewAction extends Action {

  private $page;

  private $pageMapper;

  public function __construct(Page $page, PageMapper $pageMapper) {
    $this->page = $page;
    $this->pageMapper = $pageMapper;
  }

  public function execute(Context $context) {
    $id = $context->get('id');

    if ($id == 'all') {
      $pages = $this->pageMapper->findAll();

      $title = 'All Content';
      $content = new Template('Nigel:WebsitePackage:page:index', array(
        'pages' => $pages,
      ));
    } else {
      $this->page->setId($id);
      $this->pageMapper->find($this->page);

      $title = $this->page->getTitle();
      $content = new Template('Nigel:WebsitePackage:page:view', (array) $this->page);
    }

    $template = new Template('Nigel:WebsitePackage:html', array(
      'title' => $title,
      'page' => $content
    ));
    $template->addStyle('Nigel:WebsitePackage:default');
    $template->addScript('Nigel:WebsitePackage:default');

    return new Response($template->render());
  }

}

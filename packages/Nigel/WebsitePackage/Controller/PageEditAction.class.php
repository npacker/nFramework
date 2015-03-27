<?php

namespace Nigel\WebsitePackage;

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Response;

class PageEditAction extends Action {

  private $page;

  private $pageMapper;

  public function __construct(Page $page, PageMapper $pageMapper) {
    $this->page = $page;
    $this->pageMapper = $pageMapper;
  }

  public function execute(Context $context) {
    $id = $context->get('id');
    $title = $context->get('title');
    $content = $context->get('content');
    $this->page->setId($id);

    if (isset($title) && isset($content)) {
      $this->page->setTitle($title);
      $this->page->setContent($content);
      $this->pageMapper->update($this->page);
    } else {
      $this->pageMapper->find($this->page);
    }

    $title = $this->page->getTitle();

    if (empty($title)) {
      throw new ResourceNotFoundException('The page could not be found.');
    }

    $variables = (array) $this->page;
    $variables['action'] = url('page', $id, 'edit');

    $template = new Template('Nigel:WebsitePackage:html', array(
      'title' => "Editing page <em>{$this->page->getTitle()}</em>",
      'page' => new Template('Nigel:WebsitePackage:page:edit', $variables)
    ));
    $template->addStyle('Nigel:WebsitePackage:default');
    $template->addScript(array(
      'Nigel:WebsitePackage:default',
      'Nigel:WebsitePackage:jquery',
      'Nigel:WebsitePackage:ckeditor:ckeditor',
      'Nigel:WebsitePackage:editor',
    ));

    return new Response($template->render());
  }

}

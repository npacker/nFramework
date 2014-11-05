<?php

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Response;

class PageViewAction extends Action {

  public function execute(Context $context) {
    $mapper = new PageMapper();
    $id = $context->get('path_argument');

    if ($id == 'all') {
      $pages = $mapper->findAll();

      $variables['pages'] = $pages;
      $variables['base_url'] = base_url();
      $variables['base_path'] = base_path();

      $title = 'All Content';
      $content = new Template('page/index', $variables);
    } else {
      $page = new Page();
      $page->setId($id);
      $mapper->find($page);

      $title = $page->getTitle();
      $content = new Template('page/view', (array) $page);
    }

    $template = new Template('html', array(
      'title' => $title,
      'header' => new Template('header', array('base_url' => base_url(), 'base_path' => base_path())),
      'page' => $content,
      'footer' => new Template('footer')
    ));
    $template->addStyle('default');
    $template->addScript('default');

    return new Response($template->parse());
  }

}

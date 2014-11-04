<?php

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Response;

class DefaultViewAction extends Action {

  public function execute(Context $context) {
    $template = new Template('html', array(
     'title' => 'Welcome',
     'header' => new Template('header', array('base_url' => base_url(), 'base_path' => base_path())),
     'page' => new Template('default/page'),
     'footer' => new Template('footer')
    ));
    $template->addStyle('default');
    $template->addScript('default');

    return new Response($template->parse());
  }

}
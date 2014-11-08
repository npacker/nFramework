<?php

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Response;

class DefaultViewAction extends Action {

  public function execute(Context $context) {
    $template = new Template('Nigel:Website:html', array(
     'title' => 'Welcome',
     'header' => new Template('Nigel:Website:header', array('base_url' => base_url(), 'base_path' => base_path())),
     'page' => '<p>No homepage has been set.</p>',
     'footer' => new Template('Nigel:Website:footer')
    ));
    $template->addStyle('default');
    $template->addScript('default');

    return new Response($template->parse());
  }

}
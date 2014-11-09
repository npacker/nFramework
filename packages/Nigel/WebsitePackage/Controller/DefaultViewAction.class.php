<?php

namespace Nigel\WebsitePackage;

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Response;

class DefaultViewAction extends Action {

  public function execute(Context $context) {
    $template = new Template('Nigel:WebsitePackage:html', array(
     'title' => 'Welcome',
     'page' => '<p>No homepage has been set.</p>'
    ));
    $template->addStyle('default');
    $template->addScript('default');

    return new Response($template->parse());
  }

}

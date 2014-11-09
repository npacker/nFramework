<?php

namespace nFramework;

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Model\HttpError;
use nFramework\Response;

class HttpErrorViewAction extends Action {

  public function execute(Context $context) {
    $requestUrl = $context->get('uri');
    $code = $context->get('code');
    $message = $context->get('message');
    $protocol = $context->get('SERVER_PROTOCOL');

    switch ($code) {
      case HttpError::HTTP_ERROR_ACCESS_DENIED:
        $title = "403: Forbidden";
        $realMessage = "Access denied. {$message}";
        $status = "{$protocol} 403 Forbidden";
        break;
      case HttpError::HTTP_ERROR_SERVER_ERROR:
        $title = "500: Internal Server Error";
        $realMessage = "The server encountered an error: {$message}";
        $status = "{$protocol} 500 Internal Server Error";
        break;
      default:
        $title = "404: Not Found";
        $realMessage = "The page {$requestUrl} could not be found.";
        $status = "{$protocol} 404 Not Found";
    }

    if ($code < 500) {
      $level = 'warn';
    } else {
      $level = 'critical';
    }

    $httpError = new HttpError(array(
      'title' => $title,
      'code' => $code,
      'requestUrl' => $requestUrl,
      'message' => $realMessage,
      'level' => $level
    ));

    $template = new Template('Nigel:WebsitePackage:html', array(
      'title' => $httpError->getTitle(),
      'page' => new Template('Nigel:WebsitePackage:httperror:view', (array) $httpError)
    ));
    $template->addStyle('default');
    $template->addScript('default');

    $response = new Response($template->parse());

    return $response->status($status);
  }

}

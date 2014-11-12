<?php

namespace nFramework\Controller;

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Model\HttpError;
use nFramework\Response;

class HttpErrorViewAction extends Action {

  public function execute(Context $context) {
    $uri = $context->get('uri');
    $code = $context->get('code');
    $message = $context->get('message');
    $protocol = $context->get('SERVER_PROTOCOL');

    switch ($code) {
      case HttpError::ACCESS_DENIED:
        $title = '403: Forbidden';
        $realMessage = "Access denied. {$message}";
        $status = "{$protocol} 403 Forbidden";
        break;
      case HttpError::NOT_FOUND:
        $title = '404: Not Found';
        $realMessage = "The page {$uri} could not be found.";
        $status = "{$protocol} 404 Not Found";
        break;
      default:
        $title = '500: Internal Server Error';
        $realMessage = "The server encountered an error: {$message}";
        $status = "{$protocol} 500 Internal Server Error";
    }

    if ($code < 500) {
      $level = 'warning';
    } else {
      $level = 'error';
    }

    $httpError = new HttpError(array(
      'title' => $title,
      'code' => $code,
      'uri' => $uri,
      'message' => $realMessage,
      'level' => $level
    ));

    $template = new Template('::base', array(
      'title' => $httpError->getTitle(),
      'content' => new Template('::HttpError:View', (array) $httpError),
      'level' => $httpError->getLevel()
    ));
    $template->addStyle('::normalize');
    $template->addStyle('::layout');
    $template->addStyle('::typography');
    $template->addStyle('::color');

    $response = new Response($template->parse());

    return $response->status($status);
  }

}

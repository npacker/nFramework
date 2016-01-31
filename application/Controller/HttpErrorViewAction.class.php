<?php

namespace nFramework\Controller;

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Model\HttpError;
use nFramework\Response;

class HttpErrorViewAction implements Action {

  public function execute(Context $context) {
    $code = $context->get('code');
    $uri = $context->get('uri');
    $message = $context->get('message');
    $level = ($code < 500) ? 'warning' : 'error';
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
    $template
      ->addStyle('::normalize')
      ->addStyle('::layout')
      ->addStyle('::typography')
      ->addStyle('::color');

    $response = new Response($template->render());

    return $response->status($status);
  }

}

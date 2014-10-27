<?php

use nFramework\Action;
use nFramework\Context;
use nFramework\View\Template;
use nFramework\Model\HttpError;

class HttpErrorViewAction extends Action {

  public function execute(Context $context) {
    $requestUrl = $context->get('uri');

    if ($requestUrl == '/') {
      $defaults = new DefaultViewAction();
      return $defaults->execute($context);
    }

    $code = $context->get('code');
    $message = $context->get('message');
    $protocol = $context->get('SERVER_PROTOCOL');

    switch ($code) {
      case HttpError::HTTP_ERROR_ACCESS_DENIED:
        $title = "403: Forbidden";
        $realMessage = "Access denied. {$message}";
        $response = "{$protocol} 403 Forbidden";
        break;
      case HttpError::HTTP_ERROR_SERVER_ERROR:
        $title = "500: Internal Server Error";
        $realMessage = "The server encountered an error: {$message}";
        $response = "{$protocol} 500 Internal Server Error";
        break;
      default:
        $title = "404: Not Found";
        $realMessage = "The page {$requestUrl} could not be found.";
        $response = "{$protocol} 404 Not Found";
    }

    if ($code < 500) {
      $level = 'warn';
    } else {
      $level = 'critical';
    }

    $httpError = new HttpError(
      array(
        'title' => $title,
        'code' => $code,
        'requestUrl' => $requestUrl,
        'message' => $realMessage,
        'level' => $level));

    $data['title'] = $httpError->getTitle();
    $data['content'] = new Template('httperror/view', (array) $httpError);
    $data['template'] = 'html';
    $data['response'] = $response;

    return $data;
  }

}

<?php

class HttpErrorViewAction extends Action implements iAction {

  public function execute(ActionContext $context) {
    $uri = $context->get('uri');

    if ($uri == '/') {
      $defaults = new DefaultViewAction();
      return $defaults->execute($context);
    }

    $code = $context->get('code');
    $message = $context->get('message');
    $protocol = $context->get('SERVER_PROTOCOL');

    switch ($code) {
      case HttpError::HTTP_ERROR_ACCESS_DENIED:
        $title = "403: Forbidden";
        $realMessage = "Access denied.";
        $header = "{$protocol} 403 Forbidden";
        break;
      case HttpError::HTTP_ERROR_SERVER_ERROR:
        $title = "500: Internal Server Error";
        $realMessage = "The server encountered an error: {$message}";
        $header = "{$protocol} 500 Internal Server Error";
        break;
      default:
        $title = "404: Not Found";
        $realMessage = "The page {$uri} could not be found.";
        $header = "{$protocol} 404 Not Found";
    }

    if ($code < 500) {
      $level = 'warn';
    } else {
      $level = 'critical';
    }

    $httpError = new \HttpError($title, $code, $uri, $realMessage, $level);

    $data = array(
      'title' => $httpError->getTitle(),
      'content' => new Template('httperror/view', (array) $httpError),
      'template' => 'html',
      'header' => $header);

    return $data;
  }

}
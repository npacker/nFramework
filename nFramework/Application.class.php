<?php

namespace nFramework;

use Exception;
use nFramework\Exception\AccessDeniedException;
use nFramework\Exception\ActionNotFoundException;
use nFramework\Exception\ResourceNotFoundException;
use nFramework\View\Template;
use nFramework\Model\HttpError;

class Application {

  protected $action;

  protected $view;

  public function serve(Request $request) {
    $actionFactory = new AppController();

    try {
      $actionFactory->build($request);
      $action = $actionFactory->getAction();
      $parameters = array_merge($actionFactory->getParameters(), $request->get(), $request->post(), $request->server());
      $context = new Context($parameters);
      $this->dispatch($action, $context);
    } catch (Exception $e) {
      $action = new \HttpErrorViewAction();
      $context = new Context();
      $context->set('uri', $request->path()->value());
      $context->set('message', $e->getMessage());

      if ($e instanceof ResourceNotFoundException) {
        $context->set('code', HttpError::HTTP_ERROR_NOT_FOUND);
      } else if ($e instanceof AccessDeniedException) {
        $context->set('code', HttpError::HTTP_ERROR_ACCESS_DENIED);
      } else {
        $context->set('code', HttpError::HTTP_ERROR_SERVER_ERROR);
      }

      $this->dispatch($action, $context);
    }
  }

  protected function dispatch(Action $action, Context $context) {
    $response = $action->execute($context);

    if (!isset($response->status)) {
      $response->status("{$context->get('SERVER_PROTOCOL')} 200 OK");
    }

    $response->send();
  }

}
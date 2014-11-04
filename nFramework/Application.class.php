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
    $actionFactory = new ActionFactory();

    try {
      $context = new Context($this->parseArguments($request));
      $action = $actionFactory->getAction($this->parseAction($request));
      $this->dispatch($action, $context);
    } catch (Exception $e) {
      $context = new Context();
      $context->set('uri', $request->path()->value());
      $context->set('message', $e->getMessage());
      $action = new \HttpErrorViewAction();

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

  protected function parseAction(Request $request) {
    $path = $request->path()->components();
    $action = '';

    if (count($path) >= 2) {
      $action = ucfirst(strtolower($path[0])) . ucfirst(strtolower($path[1]));
    } else if (count($path) == 1) {
      $action = ucfirst(strtolower($path[0]));
    }

    return $action;
  }

  protected function parseArguments(Request $request) {
    $path = $request->path()->components();
    $arguments = array();

    if (count($path) >= 3) {
      $arguments['path_argument'] = $path[2];
    } else {
      $arguments['path_argument'] = '';
    }

    $arguments = array_merge(
      $arguments,
      $request->get(),
      $request->post(),
      $request->server());

    return $arguments;
  }

}
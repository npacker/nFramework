<?php

namespace nFramework;

use Exception;
use nFramework\Exception\AccessDeniedException;
use nFramework\Exception\ActionNotFoundException;
use nFramework\Exception\ResourceNotFoundException;
use nFramework\Model\HttpError;

final class Application {

  private $packages;

  public function __construct() {
    $this->packages = array();
  }

  public function registerPackage(Package $package) {
    array_push($this->packages, $package);
  }

  public function serve(Request $request) {
    $controller = new AppController($this->packages);

    try {
      $action = $controller->build($request)->getAction();

      $context = new Context(array_merge(
        $controller->getParameters(),
        $request->get(),
        $request->post(),
        $request->server()
      ));

      $this->dispatch($action, $context);
    } catch (Exception $e) {
      $action = new HttpErrorViewAction();
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

  private function dispatch(Action $action, Context $context) {
    $response = $action->execute($context);

    if (!isset($response->status)) {
      $response->status($context->get('SERVER_PROTOCOL') . ' 200 OK');
    }

    $response->send();
  }

}

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

  public function handle(Request $request) {
    try {
      $controller = new AppController($this->packages);
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
      $context = new Context($request->server());

      if ($e instanceof ResourceNotFoundException) {
        $code = HttpError::HTTP_ERROR_NOT_FOUND;
      } else if ($e instanceof AccessDeniedException) {
        $code = HttpError::HTTP_ERROR_ACCESS_DENIED;
      } else {
        $code = HttpError::HTTP_ERROR_SERVER_ERROR;
      }

      $context->set('uri', $request->path()->value());
      $context->set('message', $e->getMessage());
      $context->set('code', $code);

      $this->dispatch($action, $context);
    }
  }

  private function handleException(Exception $e, Request $request) {

  }

  private function dispatch(Action $action, Context $context) {
    ob_start();
    $response = $action->execute($context);
    ob_end_clean();

    $this->send($response, $context);
  }

  private function send(Response $response, Context $context) {
    if (!isset($response->status)) {
      $response->status($context->get('SERVER_PROTOCOL') . ' 200 OK');
    }

    $response->send();
    exit();
  }

}

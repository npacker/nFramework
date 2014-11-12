<?php

namespace nFramework;

use Exception;
use nFramework\Controller\HttpErrorViewAction;
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
      $context = new Context(
        $controller->getParameters(),
        $request->get(),
        $request->post(),
        $request->server()
      );

      $this->dispatch($action, $context);
    } catch (Exception $e) {
      $this->handleException($e, $request);
    }
  }

  private function handleException(Exception $e, Request $request) {
    $context = new Context($request->server());
    $context
      ->set('uri', $request->path()->value())
      ->set('message', $e->getMessage())
      ->set('code', HttpError::code($e));

    $this->dispatch(new HttpErrorViewAction(), $context);
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

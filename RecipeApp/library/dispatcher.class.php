<?php

class Dispatcher {
  protected $controller;
  protected $action;
  protected $arguments;

  public function forward(Request $request, Response $response) {
    $controller = $this->parseController($request);
    $action = $this->parseAction($request);
    $arguments = $this->parseArguments($request);

    try {
      $this->setController($controller);
      $this->setAction($action);
      $this->setArguments($arguments);
      $this->dispatch($response);
    } catch (PDOException $e) {
      $this->setController('HttpErrorController');
      $this->setAction('view');
      $this->setArguments(
          array(
            'error_code' => HttpError::HTTP_ERROR_SERVER_ERROR,
            'error_message' => $e->getMessage(),
            'request_uri' => $request->getUri()
          ));
      $this->dispatch($response);
    } catch (Exception $e) {
      $this->setController('HttpErrorController');
      $this->setAction('view');
      $this->setArguments(
          array(
            'error_code' => HttpError::HTTP_ERROR_NOT_FOUND,
            'error_message' => $e->getMessage(),
            'request_uri' => $request->getUri()
          ));
      $this->dispatch($response);
    }
  }

  protected function dispatch(Response $response) {
    $action = $this->action;

    if (empty($this->arguments)) {
      $this->controller->$action();
    } else {
      $this->controller->$action($this->arguments);
    }
  }

  protected function parseController(Request $request) {
    $pathArgs = $request->getArguments();

    $controller = null;

    if (count($pathArgs) >= 1) {
      $controller = $this->controllerName($pathArgs[0]);
    }

    return $controller;
  }

  protected function parseAction(Request $request) {
    $pathArgs = $request->getArguments();
    $action = null;

    if (count($pathArgs) >= 2) {
      $action = $pathArgs[1];
    }

    return $action;
  }

  protected function parseArguments(Request $request) {
    $pathArgs = $request->getArguments();
    $arguments = array();

    if (count($pathArgs) >= 3) {
      array_push($arguments, $pathArgs[2]);
    }

    return $arguments;
  }

  protected function setController($controller) {
    if (!class_exists($controller, true)) {
      throw new Exception();
    }

    $this->controller = new $controller();
  }

  protected function setAction($action) {
    if (!method_exists($this->controller, $action)) {
      throw new Exception();
    }

    $this->action = $action;
  }

  protected function setArguments($arguments) {
    if (empty($arguments)) {
      throw new Exception();
    }

    $this->arguments = $arguments;
  }

  protected function controllerName($controller) {
    $controllerName = '';

    if (!empty($controller)) {
      $controllerName = $controller . 'Controller';
    }

    return $controllerName;
  }
}
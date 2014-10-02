<?php

class Dispatcher {
  protected $controller;
  protected $action;
  protected $arguments;
  protected $request;
  protected $response;

  public function forward(Request $request, Response $response) {
    $this->request = $request;
    $this->response = $response;

    $controller = $this->parseController($this->request);
    $action = $this->parseAction($this->request);
    $arguments = $this->parseArguments($this->request);

    $serverProtocol = $this->request->getServer('SERVER_PROTOCOL');

    try {
      $this->prepare(
        "{$serverProtocol} 200 OK",
        $controller,
        $action,
        $arguments
      );
      $this->dispatch();
    } catch (PDOException $e) {
      $this->prepare(
        "{$serverProtocol} 500 Internal Server Error",
        'HttpErrorController',
        'view',
        array(
          'code' => HttpError::HTTP_ERROR_SERVER_ERROR,
          'uri' => $this->request->getUri(),
          'message' => $e->getMessage(),
        )
      );
      $this->dispatch();
    } catch (Exception $e) {
      $this->prepare(
        "{$serverProtocol} 404 Not Found",
        'HttpErrorController',
        'view',
        array(
          'code' => HttpError::HTTP_ERROR_NOT_FOUND,
          'uri' => $this->request->getUri(),
          'message' => $e->getMessage(),
        )
      );
      $this->dispatch();
    }
  }

  protected function prepare($header, $controller, $action, $arguments) {
    $this->response->setHeader($header);
    $this->setController($controller);
    $this->setAction($action);
    $this->setArguments($arguments);
  }

  protected function dispatch() {
    $action = $this->action;
    $data = $this->controller->$action($this->arguments);

    $data['header'] = new Template('header', array('base_url' => base_url(), 'base_path' => base_path()));
    $data['footer'] = new Template('footer');

    $template = new Template('html', $data);
    $template->addStyle('default');
    $template->addScript('default');

    $this->response->setTemplate($template);
    $this->response->send();
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
      $arguments['path_argument'] = $pathArgs[2];
    }

    $arguments = array_merge($arguments, $request->getGet(), $request->getPost());

    return $arguments;
  }

  protected function setController($controller) {
    if (!class_exists($controller, true)) {
      throw new Exception("Undefined controller");
    }

    $this->controller = new $controller();
  }

  protected function setAction($action) {
    if (!method_exists($this->controller, $action)) {
      throw new Exception("Undefined action");
    }

    $this->action = $action;
  }

  protected function setArguments($arguments) {
    if (empty($arguments)) {
      throw new Exception("Arguments were not defined");
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

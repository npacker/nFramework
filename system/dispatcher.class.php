<?php

class Dispatcher {

  public function forward(Request $request, Response $response) {
    $actionFactory = new ActionFactory();

    try {
      $context = new ActionContext($this->parseArguments($request));
      $action = $actionFactory->get($this->parseAction($request));
      $this->dispatch($action, $context, $response);
    } catch (Exception $e) {
      $context = new ActionContext();
      $context->set('uri', $request->getUri());
      $context->set('message', $e->getMessage());
      $action = $actionFactory->get('HttpErrorView');

      if ($e instanceof PDOException) {
        $context->set('code', HttpError::HTTP_ERROR_SERVER_ERROR);
      } else if ($e instanceof ErrorException) {
        $context->set('code', HttpError::HTTP_ERROR_SERVER_ERROR);
      } else if ($e instanceof AccessDeniedException) {
        $context->set('code', HttpError::HTTP_ERROR_ACCESS_DENIED);
      } else {
        $context->set('code', HttpError::HTTP_ERROR_NOT_FOUND);
      }

      $this->dispatch($action, $context, $response);
    }
  }

  protected function dispatch(Action $action, ActionContext $context, Response $response) {
    $data = $action->execute($context);

    if (array_key_exists('location', $data)) {
      $response->setLocationHeader($data['location']);
    } else {
      if (array_key_exists('response', $data)) {
        $response->setResponseHeader($data['response']);
      } else {
        $response->setResponseHeader(
          "{$context->get('SERVER_PROTOCOL')} 200 OK");
      }

      $templateData = array();
      $templateData['title'] = strip_tags($data['title']);
      $templateData['header'] = new Template(
        'header',
        array('base_url' => base_url(),'base_path' => base_path()));
      $templateData['navigation'] = '';
      $templateData['page_title'] = $data['title'];
      $templateData['page'] = $data['content'];
      $templateData['footer'] = new Template('footer');

      $template = new Template($data['template'], $templateData);
      $template->addStyle('default');
      $template->addScript('default');

      $response->setContent($template->parse());
    }

    $response->send();
  }

  protected function parseAction(Request $request) {
    $path = $request->getPathComponents();
    $action = '';

    if (count($path) >= 2) {
      $action = ucfirst(strtolower($path[0])) . ucfirst(strtolower($path[1]));
    } else if (count($path) == 1) {
      $action = ucfirst(strtolower($path[0]));
    }

    return $action;
  }

  protected function parseArguments(Request $request) {
    $path = $request->getPathComponents();
    $arguments = array();

    if (count($path) >= 3) {
      $arguments['path_argument'] = $path[2];
    } else {
      $arguments['path_argument'] = '';
    }

    $arguments = array_merge(
      $arguments,
      $request->getGet(),
      $request->getPost(),
      $request->getServer());

    return $arguments;
  }

}
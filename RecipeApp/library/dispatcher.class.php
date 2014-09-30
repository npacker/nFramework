<?php

class Dispatcher {
  protected static $controller;
  protected static $action;
  protected static $args;

  final private function __construct() {}

  final private function __clone() {}

  public static function forward($request) {
    $params = $request->getParams();
    $args = array(
      $request->getQuery()
    );
    
    try {
      self::setController(array_shift($params));
      self::setAction(array_shift($params));
      self::setArgs($args);
    } catch (Exception $e) {
      self::setController('HttpErrors');
      self::setAction('view');
      self::setArgs(
          array(
            'error_code' => HTTP_ERROR_NOT_FOUND,
            'error_message' => $e->getMessage(),
            'request_uri' => $request->getUri(),
          ));
    }
    
    self::dispatch();
  }

  protected static function dispatch() {
    $action = self::$action;
    
    if (empty(self::$args)) {
      self::$controller->$action();
    } else {
      self::$controller->$action(self::$args);
    }
  }

  protected static function setController($controller) {
    $controller = self::controllerName($controller);
    
    if (!class_exists($controller, true)) {
      throw new Exception();
    }
    
    self::$controller = new $controller();
  }

  protected static function setAction($action) {
    if (!method_exists(self::$controller, $action)) {
      throw new Exception();
    }
    
    self::$action = $action;
  }

  protected static function setArgs(array $args) {
    self::$args = $args;
  }

  protected static function controllerName($controller) {
    if (!empty($controller)) {
      $controllerName = substr_replace($controller, '', -1) . 'Controller';
    } else {
      $controllerName = '';
    }
    
    return $controllerName;
  }
}
<?php

namespace nFramework;

use RuntimeException;
use ReflectionClass;

final class DependencyContainer {

  public function build($instantiable) {
    $reflector = new ReflectionClass($instantiable);

    if (!$reflector->isInstantiable()) {
      throw new RuntimeException("Target class {$instantiable} is not instantiable.");
    }

    $constructor = $reflector->getConstructor();

    if (is_null($constructor)) {
      return $reflector->newInstanceWithoutConstructor();
    }

    $parameters = $constructor->getParameters();
    $arguments = $this->getArguments($parameters);

    return $reflector->newInstanceArgs($arguments);
  }

  private function getArguments(array $parameters) {
    $arguments = array();

    foreach ($parameters as $parameter) {
      $concrete = $parameter->getClass();

      if (is_null($concrete)) {
        if (!$parameter->isOptional()) {
          throw new RuntimeException('Could not satisfy dependency ' . $parameter->getName());
        }

        array_push($arguments, $parameter->getDefaultValue());
      } else {
        array_push($arguments, $this->build($concrete->getName()));
      }
    }

    return $arguments;
  }

}

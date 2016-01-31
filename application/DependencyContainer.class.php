<?php

namespace nFramework;

use RuntimeException;
use ReflectionClass;
use nFramework\IO\File\FileReader;
use nFramework\IO\File\JsonParser;

final class DependencyContainer {

  // Instances loaded from container.json
  private $instances;

  private $settings;

  private $container;

  /**
   * Load the classes specified in container.json. Get the arguments for these
   * classes from services.json.
   */
  public function __construct(array $packages) {
    $path = ROOT . DS . 'config' . DS . 'container.json';
    $this->container = $this->loadConfig($path);

    $path = ROOT . DS . 'config' . DS . 'services.json';
    $this->settings = $this->loadConfig($path);

    $this->instances = $this->instantiateServices($this->container, $this->settings);
    // Instantiate each class in container.json with the arguments from
    // services.json.
    //
    // Lookups in $instances will be based on the keys in dependencies.json,
    // which will return an instantiated, concrete class - no need for further
    // calls to $this->build() for these instances.
  }

  /**
   * Load dependencies.json for the given route (may need to make a separate method
   * for that). Use the keys defined there to search the classes loaded at
   * startup from container.json. Prefer to load those classes if they are found
   * ahead of instantiating a new instance of a class. This will effect
   * singelton behavior without a singelton.
   */
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
      // Loop up the parameter name in dependencies.json.
      // Use the key from dependencies.json to loop up the class in
      // container.json.
      // Push the instantiated class from $this->instances onto the arguments
      // array - skip setting a default value or instantiating another class
      // instance.
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

  /**
   * Load a JSON config file at the given path.
   */
  private function loadConfig($path) {
    $reader = new FileReader($path);
    $parser = new JsonParser($reader->read());

    return $parser->readArray();
  }

  /**
   * Instantiate service classes as defined in container.json and add them to
   * tine instances array.
   */
  private function instantiateServices(array $container, array $settings) {
    $instances = array();

    foreach ($container as $type => $service) {
      foreach ($service as $name => $class) {
        $realname = $class;
        $namespace = $this->extractAssetNamespace($realname, "\\");
        $fullname = 'nFramework' . $namespace . $realname;

        if (class_exists($fullname)) {
          $reflector = new ReflectionClass($fullname);

          if ($reflector->isInstantiable()) {
            $instances[$type][$name] = $reflector->newInstanceArgs($settings[$type][$name]);
          }
        }
      }
    }

    return $instances;
  }

  /**
   * Parse the colon delimited class identifiers. This should be moved to an
   * appropriate location in the application, since it is used in multiple
   * locations.
   */
  private function extractAssetNamespace(&$asset, $separator = DS) {
    $parts = explode(':', $asset);
    $namespace = implode($separator, array_splice($parts, 0, 2));
    $asset = implode($separator, $parts);

    return $namespace;
  }

}

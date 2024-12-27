<?php

namespace Mugonat\Container;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Mugonat\Container\Exceptions\NotFoundException;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionException;

/**
 * A Dependency Injection (DI) container for managing and resolving dependencies.
 * Implements the ContainerInterface to comply with a PSR-11 interface.
 */
class Container implements ContainerInterface
{
    private static ?Container $instance = null;

    private array $services = [];

    /**
     * Provides access to the singleton instance of the Container class. If the instance does not already exist,
     * it creates and initializes a new one.
     *
     * @return Container The singleton instance of the Container class.
     */
    public static function instance(): Container
    {
        return self::$instance ??= new self();
    }

    /**
     * Retrieves an item based on the provided identifier. If the retrieved item is an instance of ReflectionClass,
     * it will return the instance created by the `getInstance` method; otherwise, it will return the item as is.
     *
     * @param string $id The identifier of the item to retrieve.
     *
     * @return mixed The retrieved item or an instance created by the `getInstance` method.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function get(string $id)
    {
        $item = $this->resolve($id);
        if (!($item instanceof ReflectionClass)) {
            return $item;
        }
        return $this->getInstance($item);
    }

    /**
     * Checks if an item with the given identifier exists and is usable.
     * An identifier can point to an instantiable class or a non-class item.
     *
     * @param string $id The identifier of the item to check.
     *
     * @return bool Returns true if the item exists and is usable; otherwise, false.
     *
     */
    public function has(string $id): bool
    {
        try {
            $item = $this->resolve($id);
        } catch (NotFoundException $e) {
            return false;
        }

        if ($item instanceof ReflectionClass) {
            return $item->isInstantiable();
        }

        return isset($item);
    }

    public function set(string $key, $value): Container
    {
        $this->services[$key] = $value;
        return $this;
    }

    /**
     * @throws NotFoundException
     */
    private function resolve($id)
    {
        try {
            $name = $id;
            if (isset($this->services[$id])) {
                $name = $this->services[$id];
                if (is_callable($name)) {
                    return $name();
                }
            }
            return (new ReflectionClass($name));
        } catch (ReflectionException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Creates and returns an instance of the provided ReflectionClass. If the constructor does not require parameters,
     * it instantiates the class directly. If parameters are required, it resolves the dependencies and constructs the
     * instance with the resolved arguments.
     *
     * @param ReflectionClass $item The reflection of the class to instantiate.
     *
     * @return object The instantiated object.
     *
     * @throws ReflectionException If the instantiation or parameter resolution fails.
     * @throws ContainerExceptionInterface If dependency resolution fails.
     * @throws NotFoundExceptionInterface If a required dependency cannot be found.
     */
    private function getInstance(ReflectionClass $item): object
    {
        $constructor = $item->getConstructor();

        if (is_null($constructor) || $constructor->getNumberOfRequiredParameters() == 0) {
            return $item->newInstance();
        }

        $params = [];

        foreach ($constructor->getParameters() as $param) {
            if ($type = $param->getType()) {
                $params[] = $this->get($type->getName());
            }
        }

        return $item->newInstanceArgs($params);
    }
}
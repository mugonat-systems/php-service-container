<?php

namespace Mugonat\Container;

use Exception;
use Mugonat\Container\Interfaces\ContainerExceptionInterface;

if(!function_exists('dependency')) {
    /**
     * Retrieves a dependency from the container by its name.
     *
     * @template T
     * @param class-string<T> $name The name of the dependency to retrieve.
     * @return T The requested dependency instance.
     * @throws Exception|ContainerExceptionInterface
     */
    function dependency(string $name) {
        return Container::instance()->get($name);
    }
}

if(!function_exists('dependency_exists')) {
    /**
     * Checks if a dependency exists in the container by its name.
     *
     * @template T
     * @param class-string<T> $name The name of the dependency to check.
     * @return bool True if the dependency exists, false otherwise.
     */
    function dependency_exists(string $name): bool
    {
        return Container::instance()->has($name);
    }
}
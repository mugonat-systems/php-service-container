<?php

namespace Mugonat\Container\Exceptions;

use Mugonat\Container\Interfaces\ContainerExceptionInterface;
use Exception;

/**
 * Class could not be instantiated
 */
class ContainerException extends Exception implements ContainerExceptionInterface {}


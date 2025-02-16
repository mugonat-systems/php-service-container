<?php

namespace Mugonat\Container\Exceptions;

use Mugonat\Container\Interfaces\NotFoundExceptionInterface;
use Exception;

/**
 * Class not found
 */
class NotFoundException extends Exception implements NotFoundExceptionInterface {}

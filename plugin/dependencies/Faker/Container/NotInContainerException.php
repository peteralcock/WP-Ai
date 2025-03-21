<?php

declare(strict_types=1);

namespace AIKit\Dependencies\Faker\Container;

use AIKit\Dependencies\Psr\Container\NotFoundExceptionInterface;

/**
 * @experimental This class is experimental and does not fall under our BC promise
 */
final class NotInContainerException extends \RuntimeException implements NotFoundExceptionInterface
{
}

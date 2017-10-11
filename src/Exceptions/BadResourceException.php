<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Exceptions;

use InvalidArgumentException;

/**
 * Class BadResourceException
 *
 * @package McMatters\RedmineApi\Exceptions
 */
class BadResourceException extends InvalidArgumentException implements RedmineExceptionInterface
{
    /**
     * BadResourceException constructor.
     */
    public function __construct()
    {
        parent::__construct('Bad resource passed');
    }
}

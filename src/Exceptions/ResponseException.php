<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Exceptions;

use Exception;

/**
 * Class ResponseException
 *
 * @package McMatters\RedmineApi\Exceptions
 */
class ResponseException extends Exception implements RedmineExceptionInterface
{
    /**
     * ResponseException constructor.
     *
     * @param string $message
     */
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}

<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Exceptions;

use Exception;
use Throwable;

/**
 * Class RequestException
 *
 * @package McMatters\RedmineApi\Exceptions
 */
class RequestException extends Exception implements RedmineExceptionInterface
{
    /**
     * RequestException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        $message = '',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

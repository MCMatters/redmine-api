<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources\Traits;

use InvalidArgumentException;

use function array_key_exists;

/**
 * Trait DataGetter
 *
 * @package McMatters\RedmineApi\Resources\Traits
 */
trait DataGetter
{
    /**
     * @param array $data
     * @param string $key
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    protected function getDataByKey(array $data, string $key)
    {
        if (!array_key_exists($key, $data)) {
            throw new InvalidArgumentException(
                "Response doesn't contain '{$key}'"
            );
        }

        return $data[$key];
    }
}

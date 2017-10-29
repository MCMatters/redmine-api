<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class Role
 *
 * @package McMatters\RedmineApi\Resources
 */
class Role extends AbstractResource
{
    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function list(): array
    {
        return $this->requestGet('/roles.json');
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function get(int $id): array
    {
        return $this->requestGet("/roles/{$id}.json");
    }
}

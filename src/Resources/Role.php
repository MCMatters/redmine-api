<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class Role
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_Roles
 */
class Role extends AbstractResource
{
    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Roles#GET
     */
    public function list(): array
    {
        return $this->httpClient->get('roles.json');
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Roles#GET-2
     */
    public function get(int $id): array
    {
        return $this->getDataByKey(
            $this->httpClient->get("roles/{$id}.json"),
            'role'
        );
    }
}

<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class ProjectMembership
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_Memberships
 */
class ProjectMembership extends AbstractResource
{
    /**
     * @param int|string $projectId
     * @param array $pagination
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Memberships#GET
     */
    public function list(
        $projectId,
        array $pagination = ['offset' => 0, 'limit' => 25]
    ): array {
        return $this->requestGet(
            "/projects/{$projectId}/memberships.json",
            $this->buildQueryParameters($pagination)
        );
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Memberships#GET-2
     */
    public function get(int $id): array
    {
        return $this->requestGet("/memberships/{$id}.json");
    }

    /**
     * @param int $userId
     * @param array $roleIds
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Memberships#POST
     */
    public function create(int $userId, array $roleIds): array
    {
        return $this->requestPost(
            '/projects/redmine/memberships.json',
            ['membership' => ['user_id' => $userId, 'role_ids' => $roleIds]]
        );
    }

    /**
     * @param int $id
     * @param array $roleIds
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Memberships#PUT
     */
    public function update(int $id, array $roleIds): array
    {
        return $this->requestPut(
            "/memberships/{$id}.json",
            ['membership' => ['role_ids' => $roleIds]]
        );
    }

    /**
     * @param int $id
     *
     * @return int
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Memberships#DELETE
     */
    public function delete(int $id): int
    {
        return $this->requestDelete("/memberships/{$id}.json");
    }
}

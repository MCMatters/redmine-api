<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class ProjectMembership
 *
 * @package McMatters\RedmineApi\Resources
 */
class ProjectMembership extends AbstractResource
{
    /**
     * @param int|string $projectId
     * @param array $pagination
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
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
     */
    public function delete(int $id): int
    {
        return $this->requestDelete("/memberships/{$id}.json");
    }
}

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
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Memberships#GET
     */
    public function list(
        $projectId,
        array $pagination = ['offset' => 0, 'limit' => 25]
    ): array {
        return $this->httpClient->get(
            "projects/{$projectId}/memberships.json",
            [$pagination]
        );
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Memberships#GET-2
     */
    public function get(int $id): array
    {
        return $this->getDataByKey(
            $this->httpClient->get("memberships/{$id}.json"),
            'membership'
        );
    }

    /**
     * @param int $userId
     * @param array $roleIds
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Memberships#POST
     */
    public function create(int $userId, array $roleIds): array
    {
        return $this->getDataByKey(
            $this->httpClient->post(
                'projects/redmine/memberships.json',
                ['membership' => ['user_id' => $userId, 'role_ids' => $roleIds]]
            ),
            'membership'
        );
    }

    /**
     * @param int $id
     * @param array $roleIds
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Memberships#PUT
     */
    public function update(int $id, array $roleIds): array
    {
        return $this->httpClient->put(
            "memberships/{$id}.json",
            ['membership' => ['role_ids' => $roleIds]]
        );
    }

    /**
     * @param int $id
     *
     * @return bool
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Memberships#DELETE
     */
    public function delete(int $id): bool
    {
        return $this->httpClient->delete("memberships/{$id}.json");
    }
}

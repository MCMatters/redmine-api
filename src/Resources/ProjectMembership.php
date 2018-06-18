<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

use const false, true;
use function array_merge, count;

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
     * @param int|string $projectId
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function all($projectId): array
    {
        $all = [];
        $offset = 0;
        $count = 0;

        do {
            $list = $this->list($projectId, ['offset' => $offset, 'limit' => 100]);

            $all[] = $list['memberships'];

            $count += count($list['memberships']);
            $offset += 100;
        } while ($count < $list['total_count']);

        return array_merge([], ...$all);
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

    /**
     * @param int|string $projectId
     * @param int $userId
     * @param int $roleId
     *
     * @return bool
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function hasMembershipRole($projectId, int $userId, int $roleId): bool
    {
        foreach ($this->all($projectId) as $membership) {
            if ($userId === $membership['user']['id']) {
                foreach ($membership['roles'] as $role) {
                    if ($roleId === $role['id']) {
                        return true;
                    }
                }

                return false;
            }
        }

        return false;
    }
}

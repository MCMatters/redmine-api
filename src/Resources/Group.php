<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class Group
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_Groups
 */
class Group extends AbstractResource
{
    /**
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Groups#GET
     */
    public function list(): array
    {
        return $this->httpClient->get('groups.json');
    }

    /**
     * @param int $id
     * @param array $include
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Groups#GET-2
     */
    public function get(int $id, array $include = []): array
    {
        return $this->getDataByKey(
            $this->httpClient->get(
                "groups/{$id}.json",
                ['include' => $include]
            ),
            'group'
        );
    }

    /**
     * @param string $name
     * @param array $userIds
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Groups#POST
     */
    public function create(string $name, array $userIds): array
    {
        return $this->getDataByKey(
            $this->httpClient->post(
                'groups.json',
                ['group' => ['name' => $name, 'user_ids' => $userIds]]
            ),
            'group'
        );
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Groups#PUT
     */
    public function update(int $id, array $data): array
    {
        return $this->httpClient->put("groups/{$id}.json", $data);
    }

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Groups#DELETE
     */
    public function delete(int $id): bool
    {
        return $this->httpClient->delete("groups/{$id}.json");
    }

    /**
     * @param int $id
     * @param int $userId
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Groups#POST-2
     */
    public function addUser(int $id, int $userId): array
    {
        return $this->httpClient->post(
            "groups/{$id}/users.json",
            ['user_id' => $userId]
        );
    }

    /**
     * @param int $id
     * @param int $userId
     *
     * @return bool
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Groups#DELETE-2
     */
    public function deleteUser(int $id, int $userId): bool
    {
        return $this->httpClient->delete("groups/{$id}/users/{$userId}.json");
    }
}

<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class Group
 *
 * @package McMatters\RedmineApi\Resources
 */
class Group extends AbstractResource
{
    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function list(): array
    {
        return $this->requestGet('/groups.json');
    }

    /**
     * @param int $id
     * @param array $includes
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function get(int $id, array $includes = []): array
    {
        return $this->requestGet(
            "/groups/{$id}.json",
            $this->buildQueryParameters(['include' => $includes])
        );
    }

    /**
     * @param string $name
     * @param array $userIds
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function create(string $name, array $userIds): array
    {
        return $this->requestPost(
            '/groups.json',
            ['group' => ['name' => $name, 'user_ids' => $userIds]]
        );
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function update(int $id, array $data = []): array
    {
        return $this->requestPut(
            "/groups/{$id}.json",
            $this->sanitizeData($data, ['name', 'user_ids'])
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
        return $this->requestDelete("/groups/{$id}.json");
    }

    /**
     * @param int $id
     * @param int $userId
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function addUser(int $id, int $userId): array
    {
        return $this->requestPost(
            "/groups/{$id}/users.json",
            ['user_id' => $userId]
        );
    }

    /**
     * @param int $id
     * @param int $userId
     *
     * @return int
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function deleteUser(int $id, int $userId): int
    {
        return $this->requestDelete("/groups/{$id}/users/{$userId}.json");
    }
}

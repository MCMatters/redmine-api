<?php

declare(strict_types=1);

namespace McMatters\RedmineApi\Resources;

use InvalidArgumentException;

use function array_merge, count, is_int;

use const false;

/**
 * Class User
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_Users
 */
class User extends AbstractResource
{
    /**
     * @param array $query
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Users#GET
     */
    public function list(array $query = []): array
    {
        return $this->httpClient->get('users.json', $query);
    }

    /**
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function all(): array
    {
        $all = [];
        $offset = 0;
        $count = 0;

        do {
            $list = $this->list(['offset' => $offset, 'limit' => 100]);

            $data = $this->getDataByKey($list, 'users');
            $all[] = $data;

            $count += count($data);
            $offset += 100;
        } while ($count < $this->getDataByKey($list, 'total_count'));

        return array_merge([], ...$all);
    }

    /**
     * @param int|string $id
     * @param array $query
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Users#GET-2
     */
    public function get($id, array $query = []): array
    {
        $this->checkId($id);

        return $this->getDataByKey(
            $this->httpClient->get(
                "users/{$id}.json",
                $query
            ),
            'user'
        );
    }

    /**
     * @param array $query
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function getCurrent(array $query = []): array
    {
        return $this->get('current', $query);
    }

    /**
     * @param string $login
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param array $data
     * @param bool $sendNotification
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Users#POST
     */
    public function create(
        string $login,
        string $firstName,
        string $lastName,
        string $email,
        array $data = [],
        bool $sendNotification = false
    ): array {
        $data = [
            'user' => [
                'login' => $login,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'mail' => $email,
            ] + $data,
            'send_information' => $sendNotification,
        ];

        return $this->getDataByKey(
            $this->httpClient->post('users.json', $data),
            'user'
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
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Users#PUT
     */
    public function update(int $id, array $data): array
    {
        return $this->httpClient->put("users/{$id}.json", $data);
    }

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Users#DELETE
     */
    public function delete(int $id): bool
    {
        return $this->httpClient->delete("users/{$id}.json");
    }

    /**
     * @param int|string $id
     *
     * @throws \InvalidArgumentException
     */
    protected function checkId($id)
    {
        if ('current' !== $id && !is_int($id)) {
            throw new InvalidArgumentException('The id must be integer or "current"');
        }
    }
}

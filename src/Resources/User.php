<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

use InvalidArgumentException;
use function is_int;

/**
 * Class User
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_Users
 */
class User extends AbstractResource
{
    /**
     * @param array $filters
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     */
    public function list(array $filters = []): array
    {
        $query = $this->buildQueryParameters($filters);

        return $this->requestGet('users.json', $query);
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
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     */
    public function create(
        string $login,
        string $firstName,
        string $lastName,
        string $email,
        array $data = [],
        bool $sendNotification = false
    ): array {
        $data = $this->sanitizeData($data, $this->getPermittedFields());

        $data = [
            'user'             => [
                    'login'      => $login,
                    'first_name' => $firstName,
                    'last_name'  => $lastName,
                    'mail'       => $email,
                ] + $data,
            'send_information' => $sendNotification,
        ];

        return $this->requestPost('users.json', $data);
    }

    /**
     * @param int|string $id
     * @param array $includes
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws InvalidArgumentException
     */
    public function get($id, array $includes = []): array
    {
        $this->checkId($id);

        $query = $this->buildQueryParameters(['include' => $includes]);

        return $this->requestGet("users/{$id}.json", $query);
    }

    /**
     * @param array $includes
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws InvalidArgumentException
     */
    public function getCurrent(array $includes = []): array
    {
        return $this->get('current', $includes);
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     */
    public function update(int $id, array $data): array
    {
        $data = $this->sanitizeData($data, $this->getPermittedFields());

        return $this->requestPut("users/{$id}.json", $data);
    }

    /**
     * @param int $id
     *
     * @return int
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     */
    public function delete(int $id): int
    {
        return $this->requestDelete("users/{$id}.json");
    }

    /**
     * @return array
     */
    protected function getPermittedFields(): array
    {
        return [
            'login',
            'password',
            'firstname',
            'lastname',
            'mail',
            'auth_source_id',
            'mail_notification',
            'must_change_passwd',
            'generate_password',
        ];
    }

    /**
     * @param int|string $id
     *
     * @throws InvalidArgumentException
     */
    protected function checkId($id)
    {
        if (!is_int($id) && $id !== 'current') {
            throw new InvalidArgumentException('The $id must be integer or "current"');
        }
    }
}

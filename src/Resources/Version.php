<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

use function array_filter;

use const null;

/**
 * Class Version
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_Versions
 */
class Version extends AbstractResource
{
    /**
     * @param int|string $projectId
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Versions#GET
     */
    public function list($projectId): array
    {
        return $this->httpClient->get("projects/{$projectId}/versions.json");
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Versions#GET-2
     */
    public function get(int $id): array
    {
        return $this->getDataByKey(
            $this->httpClient->get("versions/{$id}.json"),
            'version'
        );
    }

    /**
     * @param int|string $projectId
     * @param string $name
     * @param string $status
     * @param string $sharing
     * @param string|null $dueDate
     * @param string|null $description
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Versions#POST
     */
    public function create(
        $projectId,
        string $name,
        string $status = 'open',
        string $sharing = 'none',
        string $dueDate = null,
        string $description = null
    ): array {
        $data = [
            'version' => array_filter([
                'name' => $name,
                'status' => $status,
                'sharing' => $sharing,
                'due_date' => $dueDate,
                'description' => $description,
            ]),
        ];

        return $this->getDataByKey(
            $this->httpClient->post(
                "projects/{$projectId}/versions.json",
                $data
            ),
            'version'
        );
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $status
     * @param string $sharing
     * @param string|null $dueDate
     * @param string|null $description
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Versions#PUT
     */
    public function update(
        int $id,
        string $name,
        string $status = 'open',
        string $sharing = 'none',
        string $dueDate = null,
        string $description = null
    ): array {
        return $this->httpClient->put(
            "versions/{$id}.json",
            [
                'version' => array_filter([
                    'name' => $name,
                    'status' => $status,
                    'sharing' => $sharing,
                    'due_date' => $dueDate,
                    'description' => $description,
                ]),
            ]
        );
    }

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Versions#DELETE
     */
    public function delete(int $id): bool
    {
        return $this->httpClient->delete("versions/{$id}.json");
    }
}

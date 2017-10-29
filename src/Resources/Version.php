<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

use const null;
use function array_filter;

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
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Versions#GET
     */
    public function list($projectId): array
    {
        return $this->requestGet("/projects/{$projectId}/versions.json");
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Versions#GET-2
     */
    public function get(int $id): array
    {
        return $this->requestGet("/versions/{$id}.json");
    }

    /**
     * @param int|string $projectId
     * @param string $name
     * @param string $status
     * @param string $sharing
     * @param null $dueDate
     * @param string|null $description
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Versions#POST
     */
    public function create(
        $projectId,
        string $name,
        string $status = 'open',
        string $sharing = 'none',
        $dueDate = null,
        string $description = null
    ): array {
        return $this->requestPut(
            "/projects/{$projectId}/versions.json",
            [
                'version' => array_filter([
                    'name'        => $name,
                    'status'      => $status,
                    'sharing'     => $sharing,
                    'due_date'    => (string) $dueDate,
                    'description' => $description,
                ]),
            ]
        );
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $status
     * @param string $sharing
     * @param null $dueDate
     * @param string|null $description
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Versions#PUT
     */
    public function update(
        int $id,
        string $name,
        string $status = 'open',
        string $sharing = 'none',
        $dueDate = null,
        string $description = null
    ): array {
        return $this->requestPut(
            "/versions/{$id}.json",
            [
                'version' => array_filter([
                    'name'        => $name,
                    'status'      => $status,
                    'sharing'     => $sharing,
                    'due_date'    => (string) $dueDate,
                    'description' => $description,
                ]),
            ]
        );
    }

    /**
     * @param int $id
     *
     * @return int
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Versions#DELETE
     */
    public function delete(int $id): int
    {
        return $this->requestDelete("/versions/{$id}.json");
    }
}

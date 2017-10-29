<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

use const null;
use function array_filter;

/**
 * Class IssueCategory
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueCategories
 */
class IssueCategory extends AbstractResource
{
    /**
     * @param int|string $projectId
     * @param array $pagination
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueCategories#GET
     */
    public function list(
        $projectId,
        array $pagination = ['offset' => 0, 'limit' => 25]
    ): array {
        return $this->requestGet(
            "/projects/{$projectId}/issue_categories.json",
            $this->buildQueryParameters($pagination)
        );
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueCategories#GET-2
     */
    public function get(int $id): array
    {
        return $this->requestGet("/issue_categories/{$id}.json");
    }

    /**
     * @param int|string $projectId
     * @param string $name
     * @param int|null $assignedToId
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueCategories#POST
     */
    public function create(
        $projectId,
        string $name,
        int $assignedToId = null
    ): array {
        return $this->requestPost(
            "/projects/{$projectId}/issue_categories.json",
            [
                'issue_category' => array_filter([
                    'name'           => $name,
                    'assigned_to_id' => $assignedToId,
                ]),
            ]
        );
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueCategories#PUT
     */
    public function update(int $id, array $data = []): array
    {
        return $this->requestPut(
            "/issue_categories/{$id}.json",
            $this->sanitizeData($data, ['name', 'assigned_to_id'])
        );
    }

    /**
     * @param int $id
     * @param int|null $reassignToId
     *
     * @return int
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueCategories#DELETE
     */
    public function delete(int $id, int $reassignToId = null): int
    {
        return $this->requestDelete(
            "/issue_categories/{$id}.json",
            array_filter(['reassign_to_id' => $reassignToId])
        );
    }
}

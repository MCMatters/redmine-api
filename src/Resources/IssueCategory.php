<?php

declare(strict_types=1);

namespace McMatters\RedmineApi\Resources;

use function array_filter;

use const null;

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
     * @param array $query
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueCategories#GET
     */
    public function list(
        $projectId,
        array $query = []
    ): array {
        return $this->httpClient->get(
            "projects/{$projectId}/issue_categories.json",
            $query
        );
    }

    /**
     * @param int $id
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueCategories#GET-2
     */
    public function get(int $id): array
    {
        return $this->getDataByKey(
            $this->httpClient->get("issue_categories/{$id}.json"),
            'issue_category'
        );
    }

    /**
     * @param int|string $projectId
     * @param string $name
     * @param int|null $assignedToId
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueCategories#POST
     */
    public function create(
        $projectId,
        string $name,
        int $assignedToId = null
    ): array {
        return $this->getDataByKey(
            $this->httpClient->post(
                "projects/{$projectId}/issue_categories.json",
                [
                    'issue_category' => array_filter([
                        'name' => $name,
                        'assigned_to_id' => $assignedToId,
                    ]),
                ]
            ),
            'issue_category'
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
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueCategories#PUT
     */
    public function update(int $id, array $data): array
    {
        return $this->httpClient->put("issue_categories/{$id}.json", $data);
    }

    /**
     * @param int $id
     * @param int|null $reassignToId
     *
     * @return bool
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueCategories#DELETE
     */
    public function delete(int $id, int $reassignToId = null): bool
    {
        return $this->httpClient->delete(
            "issue_categories/{$id}.json",
            array_filter(['reassign_to_id' => $reassignToId])
        );
    }
}

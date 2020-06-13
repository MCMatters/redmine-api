<?php

declare(strict_types=1);

namespace McMatters\RedmineApi\Resources;

use const null;

/**
 * Class IssueRelation
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueRelations
 */
class IssueRelation extends AbstractResource
{
    /**
     * @param int $issueId
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueRelations#GET
     */
    public function list(int $issueId): array
    {
        return $this->httpClient->get("issues/{$issueId}/relations.json");
    }

    /**
     * @param int $id
     * @param array $query
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueRelations#GET-2
     */
    public function get(int $id, array $query = []): array
    {
        return $this->getDataByKey(
            $this->httpClient->get("relations/{$id}.json", $query),
            'relation'
        );
    }

    /**
     * @param int $issueId
     * @param int $issueToId
     * @param string $type
     * @param int|null $delay
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueRelations#POST
     */
    public function create(
        int $issueId,
        int $issueToId,
        string $type = 'relates',
        int $delay = null
    ): array {
        return $this->getDataByKey(
            $this->httpClient->post(
                "issues/{$issueId}/relations.json",
                [
                    'relation' => [
                        'issue_to_id' => $issueToId,
                        'relation_type' => $type,
                        'delay' => $delay,
                    ],
                ]
            ),
            'relation'
        );
    }

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueRelations#DELETE
     */
    public function delete(int $id): bool
    {
        return $this->httpClient->delete("relations/{$id}.json");
    }
}

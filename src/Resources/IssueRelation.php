<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

use const null;

/**
 * Class IssueRelation
 *
 * @package McMatters\RedmineApi\Resources
 */
class IssueRelation extends AbstractResource
{
    /**
     * @param int $issueId
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function list(int $issueId): array
    {
        return $this->requestGet("/issues/{$issueId}/relations.json");
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
            "/relations/{$id}.json",
            $this->buildQueryParameters(['include' => $includes])
        );
    }

    /**
     * @param int $issueId
     * @param int $issueToId
     * @param string $type
     * @param null $delay
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function create(
        int $issueId,
        int $issueToId,
        string $type = 'relates',
        $delay = null
    ): array {
        return $this->requestPost(
            "/issues/{$issueId}/relations.json",
            [
                'relation' => [
                    'issue_to_id'   => $issueToId,
                    'relation_type' => $type,
                    'delay'         => $delay,
                ],
            ]
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
        return $this->requestDelete("/relations/{$id}.json");
    }
}

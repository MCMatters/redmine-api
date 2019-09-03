<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

use function array_filter;

use const null;

/**
 * Class Query
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_Queries
 */
class Query extends AbstractResource
{
    /**
     * @param int|null $id
     * @param int|string|null $projectId
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Queries#GET
     */
    public function list(int $id = null, $projectId = null): array
    {
        return $this->httpClient->get(
            'queries.json',
            [array_filter(['query_id' => $id, 'project_id' => $projectId])]
        );
    }
}

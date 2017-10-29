<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

use const null;
use function array_filter;

/**
 * Class Query
 *
 * @package McMatters\RedmineApi\Resources
 */
class Query extends AbstractResource
{
    /**
     * @param int|null $id
     * @param int|string|null $projectId
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function list(int $id = null, $projectId = null): array
    {
        return $this->requestGet(
            '/queries.json',
            array_filter(['query_id' => $id, 'project_id' => $projectId])
        );
    }
}

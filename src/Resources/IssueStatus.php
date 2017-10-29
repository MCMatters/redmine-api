<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class IssueStatus
 *
 * @package McMatters\RedmineApi\Resources
 */
class IssueStatus extends AbstractResource
{
    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function list(): array
    {
        return $this->requestGet('/issue_statuses.json');
    }
}

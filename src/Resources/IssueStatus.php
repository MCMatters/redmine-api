<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class IssueStatus
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueStatuses
 */
class IssueStatus extends AbstractResource
{
    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_IssueStatuses#GET
     */
    public function list(): array
    {
        return $this->requestGet('/issue_statuses.json');
    }
}

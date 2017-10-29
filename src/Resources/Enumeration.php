<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class Enumeration
 *
 * @package McMatters\RedmineApi\Resources
 */
class Enumeration extends AbstractResource
{
    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function issuePriorities(): array
    {
        return $this->requestGet('/enumerations/issue_priorities.json');
    }

    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function timeEntryActivities(): array
    {
        return $this->requestGet('/enumerations/time_entry_activities.json');
    }

    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function documentCategories(): array
    {
        return $this->requestGet('/enumerations/document_categories.json');
    }
}

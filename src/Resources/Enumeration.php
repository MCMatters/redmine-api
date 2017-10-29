<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class Enumeration
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_Enumerations
 */
class Enumeration extends AbstractResource
{
    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Enumerations#GET
     */
    public function issuePriorities(): array
    {
        return $this->requestGet('/enumerations/issue_priorities.json');
    }

    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Enumerations#GET-2
     */
    public function timeEntryActivities(): array
    {
        return $this->requestGet('/enumerations/time_entry_activities.json');
    }

    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Enumerations#GET-3
     */
    public function documentCategories(): array
    {
        return $this->requestGet('/enumerations/document_categories.json');
    }
}

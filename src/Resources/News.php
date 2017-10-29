<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class News
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_News
 */
class News extends AbstractResource
{
    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_News#GET
     */
    public function list(): array
    {
        return $this->requestGet('/news.json');
    }

    /**
     * @param int|string $projectId
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_News#GET-2
     */
    public function projectList($projectId): array
    {
        return $this->requestGet("/projects/{$projectId}/news.json");
    }
}

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
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_News#GET
     */
    public function list(): array
    {
        return $this->httpClient->get('news.json');
    }

    /**
     * @param int|string $projectId
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_News#GET-2
     */
    public function projectList($projectId): array
    {
        return $this->httpClient->get("projects/{$projectId}/news.json");
    }
}

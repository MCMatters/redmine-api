<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class News
 *
 * @package McMatters\RedmineApi\Resources
 */
class News extends AbstractResource
{
    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
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
     */
    public function projectList($projectId): array
    {
        return $this->requestGet("/projects/{$projectId}/news.json");
    }
}

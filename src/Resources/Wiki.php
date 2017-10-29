<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class Wiki
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_WikiPages
 */
class Wiki extends AbstractResource
{
    /**
     * @param int|string $projectId
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_WikiPages#Getting-the-pages-list-of-a-wiki
     */
    public function list($projectId): array
    {
        return $this->requestGet("/projects/{$projectId}/wiki/index.json");
    }

    /**
     * @param int|string $projectId
     * @param string $title
     * @param array $includes
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_WikiPages#Getting-a-wiki-page
     */
    public function get($projectId, string $title, array $includes = []): array
    {
        return $this->requestGet(
            "/projects/{$projectId}/wiki/{$title}.json",
            $this->buildQueryParameters(['include' => $includes])
        );
    }

    /**
     * @param int|string $projectId
     * @param string $title
     * @param int $version
     * @param array $includes
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_WikiPages#Getting-an-old-version-of-a-wiki-page
     */
    public function getByVersion(
        $projectId,
        string $title,
        int $version,
        array $includes = []
    ): array {
        return $this->requestGet(
            "/projects/{$projectId}/wiki/{$title}/{$version}.json",
            $this->buildQueryParameters(['include' => $includes])
        );
    }

    /**
     * @param int|string $projectId
     * @param string $title
     * @param array $data
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_WikiPages#Creating-or-updating-a-wiki-page
     */
    public function updateOrCreate(
        $projectId,
        string $title,
        array $data = []
    ): array {
        return $this->requestPut(
            "/projects/{$projectId}/wiki/{$title}.json",
            $this->sanitizeData(
                $data,
                [
                    'text',
                    'version',
                    'comments',
                    'parent' => ['title'],
                    'upload',
                ]
            )
        );
    }

    /**
     * @param int|string $projectId
     * @param string $title
     *
     * @return int
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_WikiPages#Deleting-a-wiki-page
     */
    public function delete($projectId, string $title): int
    {
        return $this->requestDelete("/projects/{$projectId}/wiki/{$title}.json");
    }
}

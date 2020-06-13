<?php

declare(strict_types=1);

namespace McMatters\RedmineApi\Resources;

use InvalidArgumentException;

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
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_WikiPages#Getting-the-pages-list-of-a-wiki
     */
    public function list($projectId): array
    {
        return $this->httpClient->get("projects/{$projectId}/wiki/index.json");
    }

    /**
     * @param int|string $projectId
     * @param string $title
     * @param array $include
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_WikiPages#Getting-a-wiki-page
     */
    public function get($projectId, string $title, array $include = []): array
    {
        return $this->getDataByKey(
            $this->httpClient->get(
                "projects/{$projectId}/wiki/{$title}.json",
                ['include' => $include]
            ),
            'wiki_page'
        );
    }

    /**
     * @param int|string $projectId
     * @param string $title
     * @param int $version
     * @param array $include
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_WikiPages#Getting-an-old-version-of-a-wiki-page
     */
    public function getByVersion(
        $projectId,
        string $title,
        int $version,
        array $include = []
    ): array {
        return $this->getDataByKey(
            $this->httpClient->get(
                "projects/{$projectId}/wiki/{$title}/{$version}.json",
                ['include' => $include]
            ),
            'wiki_page'
        );
    }

    /**
     * @param int|string $projectId
     * @param string $title
     * @param array $data
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_WikiPages#Creating-or-updating-a-wiki-page
     */
    public function updateOrCreate(
        $projectId,
        string $title,
        array $data = []
    ): array {
        $response = $this->httpClient->put(
            "projects/{$projectId}/wiki/{$title}.json",
            ['wiki_page' => $data]
        );

        try {
            return $this->getDataByKey($response, 'wiki_page');
        } catch (InvalidArgumentException $e) {
            return $response;
        }
    }

    /**
     * @param int|string $projectId
     * @param string $title
     *
     * @return bool
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_WikiPages#Deleting-a-wiki-page
     */
    public function delete($projectId, string $title): bool
    {
        return $this->httpClient->delete("projects/{$projectId}/wiki/{$title}.json");
    }
}

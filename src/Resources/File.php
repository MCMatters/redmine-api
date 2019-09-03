<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class File
 *
 * @package McMatters\RedmineApi\Resources
 */
class File extends AbstractResource
{
    /**
     * @param string $content
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function createUploadToken(string $content): string
    {
        $upload = $this->getDataByKey(
            $this->httpClient->upload($content),
            'upload'
        );

        return $this->getDataByKey($upload, 'token');
    }

    /**
     * @param int|string $projectId
     *
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function list($projectId): array
    {
        return $this->httpClient->get("projects/{$projectId}/files.json");
    }

    /**
     * @param int|string $projectId
     * @param string $token
     * @param array $data
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function upload($projectId, string $token, array $data = []): array
    {
        return $this->getDataByKey(
            $this->httpClient->post(
                "projects/{$projectId}/files.json",
                ['file' => ['token' => $token] + $data]
            ),
            'file'
        );
    }
}

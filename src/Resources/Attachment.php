<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class Attachment
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_Attachments
 */
class Attachment extends AbstractResource
{
    /**
     * @param int $id
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Attachments#GET
     */
    public function get(int $id): array
    {
        return $this->getDataByKey(
            $this->httpClient->get("attachments/{$id}.json"),
            'attachment'
        );
    }
}

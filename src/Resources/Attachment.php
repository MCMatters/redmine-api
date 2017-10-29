<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class Attachment
 *
 * @package McMatters\RedmineApi\Resources
 */
class Attachment extends AbstractResource
{
    /**
     * @param int $id
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function get(int $id): array
    {
        return $this->requestGet("/attachments/{$id}.json");
    }
}

<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class Tracker
 *
 * @package McMatters\RedmineApi\Resources
 */
class Tracker extends AbstractResource
{
    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function list(): array
    {
        return $this->requestGet('/trackers.json');
    }
}

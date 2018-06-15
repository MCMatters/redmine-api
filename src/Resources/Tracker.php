<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class Tracker
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_Trackers
 */
class Tracker extends AbstractResource
{
    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_Trackers#GET
     */
    public function list(): array
    {
        return $this->httpClient->get('trackers.json');
    }
}

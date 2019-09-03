<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class CustomField
 *
 * @package McMatters\RedmineApi\Resources
 * @see http://www.redmine.org/projects/redmine/wiki/Rest_CustomFields
 */
class CustomField extends AbstractResource
{
    /**
     * @return array
     *
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_CustomFields#GET
     */
    public function list(): array
    {
        return $this->httpClient->get('custom_fields.json');
    }
}

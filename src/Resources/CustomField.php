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
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     * @see http://www.redmine.org/projects/redmine/wiki/Rest_CustomFields#GET
     */
    public function list(): array
    {
        return $this->requestGet('/custom_fields.json');
    }
}

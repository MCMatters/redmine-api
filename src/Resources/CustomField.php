<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

/**
 * Class CustomField
 *
 * @package McMatters\RedmineApi\Resources
 */
class CustomField extends AbstractResource
{
    /**
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RedmineExceptionInterface
     */
    public function list(): array
    {
        return $this->requestGet('/custom_fields.json');
    }
}

<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

use McMatters\RedmineApi\Contracts\ResourceContract;
use McMatters\RedmineApi\Http\Client;
use McMatters\RedmineApi\Resources\Traits\DataGetter;

/**
 * Class AbstractResource
 *
 * @package McMatters\RedmineApi\Resources
 */
abstract class AbstractResource implements ResourceContract
{
    use DataGetter;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * AbstractResource constructor.
     *
     * @param string $baseUrl
     * @param string $apiKey
     */
    public function __construct(string $baseUrl, string $apiKey)
    {
        $this->httpClient = new Client($baseUrl, $apiKey);
    }
}

<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi;

use GuzzleHttp\Client as HttpClient;
use McMatters\RedmineApi\Exceptions\BadResourceException;
use McMatters\RedmineApi\Resources\AbstractResource;
use function class_exists, strtolower, ucfirst;

/**
 * Class RedmineClient
 *
 * @package McMatters\RedmineApi
 */
class RedmineClient
{
    /**
     * @var array
     */
    protected $resources;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * Redmine constructor.
     *
     * @param string $baseUrl
     * @param string $apiKey
     */
    public function __construct(string $baseUrl, string $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $name
     *
     * @return AbstractResource
     * @throws BadResourceException
     */
    public function resource(string $name): AbstractResource
    {
        $lowerCaseName = strtolower($name);

        if (!empty($this->resources[$lowerCaseName])) {
            return $this->resources[$lowerCaseName];
        }

        $name = ucfirst($name);

        $class = __NAMESPACE__."\\Resources\\{$name}";

        if (!class_exists($class)) {
            throw new BadResourceException();
        }

        $this->resources[$lowerCaseName] = new $class(
            $this->baseUrl,
            $this->apiKey
        );

        return $this->resources[$lowerCaseName];
    }
}

<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Contracts;

/**
 * Interface HttpClientContract
 *
 * @package McMatters\RedmineApi\Contracts
 */
interface HttpClientContract
{
    /**
     * @param string $uri
     * @param array $query
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function get(string $uri, array $query = []): array;

    /**
     * @param string $uri
     * @param array $body
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function post(string $uri, array $body): array;

    /**
     * @param string $uri
     * @param array $body
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function put(string $uri, array $body): array;

    /**
     * @param string $uri
     * @param array $query
     *
     * @return bool
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function delete(string $uri, array $query = []): bool;

    /**
     * @param string $content
     * @param string $uri
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function upload(string $content, string $uri): array;
}

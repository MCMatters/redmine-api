<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Http;

use GuzzleHttp\Client as BaseClient;
use McMatters\RedmineApi\Contracts\HttpClientContract;
use McMatters\RedmineApi\Exceptions\RequestException;
use McMatters\RedmineApi\Exceptions\ResponseException;
use Throwable;
use const true;
use const JSON_ERROR_NONE;
use function array_merge, json_decode, json_last_error, json_last_error_msg,
    implode, is_array, rtrim, trim, urlencode;

/**
 * Class Client
 *
 * @package McMatters\RedmineApi\Http
 */
class Client implements HttpClientContract
{
    /**
     * @var BaseClient
     */
    protected $client;

    /**
     * Client constructor.
     *
     * @param string $baseUrl
     * @param string $apiKey
     */
    public function __construct(string $baseUrl, string $apiKey)
    {
        $this->client = new BaseClient([
            'base_uri' => rtrim($baseUrl, '/').'/',
            'headers' => [
                'X-Redmine-API-Key' => $apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * @param string $uri
     * @param array $query
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function get(string $uri, array $query = []): array
    {
        try {
            $response = $this->client->get(
                $uri,
                ['query' => $this->prepareRequestParameters($query)]
            );

            $content = $response->getBody()->getContents();
        } catch (Throwable $exception) {
            throw new RequestException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return $this->parseResponse($content);
    }

    /**
     * @param string $uri
     * @param array $body
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function post(string $uri, array $body): array
    {
        try {
            $response = $this->client->post($uri, ['json' => $body]);

            $content = $response->getBody()->getContents();
        } catch (Throwable $exception) {
            throw new RequestException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return $this->parseResponse($content);
    }

    /**
     * @param string $uri
     * @param array $body
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function put(string $uri, array $body): array
    {
        try {
            $response = $this->client->put($uri, ['json' => $body]);

            $content = $response->getBody()->getContents();
        } catch (Throwable $exception) {
            throw new RequestException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return $this->parseResponse($content);
    }

    /**
     * @param string $uri
     * @param array $query
     *
     * @return bool
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     */
    public function delete(string $uri, array $query = []): bool
    {
        try {
            $response = $this->client->delete(
                $uri,
                ['query' => $this->prepareRequestParameters($query)]
            );

            $statusCode = $response->getStatusCode();

            return $statusCode <= 200 && $statusCode > 400;
        } catch (Throwable $exception) {
            throw new RequestException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @param string $content
     * @param string $uri
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\RequestException
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    public function upload(string $content, string $uri = 'uploads.json'): array
    {
        try {
            $response = $this->client->post(
                $uri,
                [
                    'json' => $content,
                    'headers' => array_merge(
                        $this->client->getConfig('headers'),
                        ['Content-Type' => 'application/octet-stream']
                    )
                ]
            );

            $content = $response->getBody()->getContents();
        } catch (Throwable $exception) {
            throw new RequestException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }

        return $this->parseResponse($content);
    }

    /**
     * @param array $args
     *
     * @return array
     */
    protected function prepareRequestParameters(array $args = []): array
    {
        $prepared = [];

        foreach ($args as $parameters) {
            foreach ((array) $parameters as $name => $parameter) {
                $prepared[$name] = urlencode(
                    is_array($parameter)
                        ? implode(',', $parameter)
                        : (string) $parameter
                );
            }
        }

        return $prepared;
    }

    /**
     * @param string $content
     *
     * @return array
     * @throws \McMatters\RedmineApi\Exceptions\ResponseException
     */
    protected function parseResponse(string $content): array
    {
        $content = trim($content);

        if ('' === $content) {
            return [];
        }

        $content = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ResponseException(json_last_error_msg());
        }

        return $content;
    }
}

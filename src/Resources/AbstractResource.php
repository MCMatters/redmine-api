<?php

declare(strict_types = 1);

namespace McMatters\RedmineApi\Resources;

use GuzzleHttp\Client;
use McMatters\RedmineApi\Exceptions\RequestException;
use McMatters\RedmineApi\Exceptions\ResponseException;
use Throwable;
use const null, true, JSON_ERROR_NONE;
use function implode, is_array, is_callable, json_decode, json_last_error,
    json_last_error_msg, trim, urlencode;

/**
 * Class AbstractResource
 *
 * @package McMatters\RedmineApi\Resources
 */
abstract class AbstractResource
{
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
        $this->httpClient = new Client([
            'base_uri' => $baseUrl,
            'headers'  => [
                'X-Redmine-API-Key' => $apiKey,
                'Content-Type'      => 'application/json',
            ],
        ]);
    }

    /**
     * @param string $uri
     * @param array $query
     *
     * @return array
     * @throws RequestException
     * @throws ResponseException
     */
    protected function requestGet(string $uri, array $query = []): array
    {
        try {
            $response = $this->httpClient->get(
                $uri,
                ['query' => $query]
            );

            $content = $response->getBody()->getContents();

            return $this->parseJson($content);
        } catch (Throwable $e) {
            $this->throwRequestException($e);
        }
    }

    /**
     * @param string $uri
     * @param array $body
     *
     * @return array
     * @throws RequestException
     * @throws ResponseException
     */
    protected function requestPost(string $uri, array $body): array
    {
        try {
            $response = $this->httpClient->post($uri, ['json' => $body]);

            $content = $response->getBody()->getContents();

            return $this->parseJson($content);
        } catch (Throwable $e) {
            $this->throwRequestException($e);
        }
    }

    /**
     * @param string $uri
     * @param array $body
     *
     * @return array
     * @throws RequestException
     * @throws ResponseException
     */
    protected function requestPut(string $uri, array $body): array
    {
        try {
            $response = $this->httpClient->put($uri, ['json' => $body]);

            $content = $response->getBody()->getContents();

            return $this->parseJson($content);
        } catch (Throwable $e) {
            $this->throwRequestException($e);
        }
    }

    /**
     * @param string $uri
     *
     * @return int
     * @throws RequestException
     */
    protected function requestDelete(string $uri): int
    {
        try {
            $response = $this->httpClient->delete($uri);

            return $response->getStatusCode();
        } catch (Throwable $e) {
            $this->throwRequestException($e);
        }
    }

    /**
     * @param string $content
     *
     * @return array
     * @throws ResponseException
     */
    protected function parseJson(string $content): array
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

    /**
     * @param array $args
     *
     * @return array
     */
    protected function buildQueryParameters(...$args): array
    {
        $queryParts = [];

        foreach ($args as $parameters) {
            foreach ((array) $parameters as $name => $parameter) {
                $queryParts[$name] = urlencode(
                    is_array($parameter)
                        ? implode(',', $parameter)
                        : $parameter
                );
            }
        }

        return $queryParts;
    }

    /**
     * @param array $data
     * @param array $permitted
     *
     * @return array
     */
    protected function sanitizeData(array $data, array $permitted = []): array
    {
        $values = [];

        if (empty($permitted)) {
            return $data;
        }

        foreach ($permitted as $field) {
            $value = $data[$field] ?? null;

            if (null !== $value) {
                $values[$field] = $value;
            }
        }

        return $values;
    }

    /**
     * @param Throwable $e
     *
     * @throws RequestException
     */
    protected function throwRequestException(Throwable $e)
    {
        throw new RequestException(
            $this->getErrorMessage($e),
            $this->getErrorCode($e),
            $e
        );
    }

    /**
     * @param Throwable $e
     *
     * @return string
     */
    protected function getErrorMessage(Throwable $e): string
    {
        $message = '';

        if (is_callable([$e, 'getResponse'])) {
            $response = $e->getResponse();

            try {
                $message = $response->getBody()->getContents();
            } catch (Throwable $x) {
                $message = $e->getMessage();
            }
        }

        return $message ?: $e->getMessage();
    }

    /**
     * @param Throwable $e
     *
     * @return int
     */
    protected function getErrorCode(Throwable $e): int
    {
        if (is_callable([$e, 'getStatusCode'])) {
            $code = $e->getStatusCode();
        } else {
            $code = $e->getCode();
        }

        return $code >= 400 && $code <= 599 ? (int) $code : 500;
    }
}

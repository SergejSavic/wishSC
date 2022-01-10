<?php

namespace App\Proxy;

use App\Contracts\Services\Auth\WishAuthServiceInterface;
use JsonException;
use SendCloud\Infrastructure\Interfaces\Required\HttpClient;
use SendCloud\Infrastructure\Logger\Logger;
use SendCloud\Infrastructure\Utility\Exceptions\HttpCommunicationException;
use SendCloud\Infrastructure\Utility\Exceptions\HttpRequestException;
use SendCloud\Infrastructure\Utility\HttpResponse;

/**
 * Class BaseProxy
 * @package App\Proxy
 */
abstract class BaseProxy
{
    private const HTTP_STATUS_CODE_TOO_MANY_REQUESTS = 429;
    private const SECONDS_UNTIL_NEXT_REQUEST = 60;

    /**
     * @var HttpClient
     */
    protected HttpClient $httpClient;

    /**
     * @var WishAuthServiceInterface
     */
    protected WishAuthServiceInterface $authService;


    /**
     * BaseProxy constructor.
     * @param HttpClient $httpClient
     * @param WishAuthServiceInterface $authService
     */
    public function __construct(HttpClient $httpClient, WishAuthServiceInterface $authService)
    {
        $this->httpClient = $httpClient;
        $this->authService = $authService;
    }

    /**
     * Returns HTTP header
     *
     * @return string[]
     */
    protected function getHeaders(): array
    {
        return [
            'content' => 'Content-Type: application/json'
        ];
    }

    /**
     * Executes HTTP GET request and returns HTTP response
     *
     * @param string $endpoint
     * @param array $parameters
     * @return array
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws JsonException
     */
    protected function get(string $endpoint, array $parameters = []): array
    {
        $response = $this->call('GET', $endpoint, [], [], $parameters);
        $results = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        return (array)$results;
    }

    /**
     * Executes HTTP POST request and returns HTTP response
     *
     * @param string $endpoint
     * @param array $body
     * @param array $parameters
     * @return array
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws JsonException
     */
    protected function post(string $endpoint, array $body, array $parameters = []): array
    {
        $response = $this->call('POST', $endpoint, $body, [], $parameters);
        $results = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        return (array)$results;
    }

    /**
     * Executes HTTP PUT request and returns HTTP response
     *
     * @param string $endpoint
     * @param array $body
     * @param array $parameters
     * @return array
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws JsonException
     */
    protected function put(string $endpoint, array $body, array $parameters = []): array
    {
        $response = $this->call('PUT', $endpoint, $body, [], $parameters);
        return $response->getBody() === '' ? [] : (array)json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Executes HTTP request and returns HTTP response
     *
     * @param string $method
     * @param string $endpoint
     * @param array $body
     * @param array $headers
     * @param array $parameters
     * @return HttpResponse
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws JsonException
     */
    protected function call(string $method, string $endpoint, array $body = [], array $headers = [], array $parameters = []): HttpResponse
    {

        $bodyString = !empty($body) ? json_encode($body, JSON_THROW_ON_ERROR) : '';

        if (empty($headers)) {
            $headers = $this->getHeaders();
        }

        $this->setParameters($parameters);

        $endpoint .= '?' . http_build_query($parameters);
        $formatEndpoint = $this->formatRequestUrl($endpoint);

        $response = $this->httpClient->request($method, $formatEndpoint, $headers, $bodyString);

        if ($response->getStatus() === self::HTTP_STATUS_CODE_TOO_MANY_REQUESTS) {
            sleep(self::SECONDS_UNTIL_NEXT_REQUEST);
            $response = $this->httpClient->request($method, $formatEndpoint, $headers, $bodyString);
        }

        if (!$response->isSuccessful()) {
            Logger::logWarning($response->getBody());
            throw new HttpRequestException($response->getBody(), $response->getStatus());
        }

        return $response;
    }

    /**
     * Concatenates endpoint to base url and removes double slashes if exists
     *
     * @param string $endpoint
     * @return string
     */
    protected function formatRequestUrl(string $endpoint): string
    {
        return $this->authService->getApiBaseUrl() . ltrim($endpoint, '/');
    }

    /**
     * Set additional parameters
     *
     * @param array $parameters
     */
    protected function setParameters(array &$parameters): void
    {

    }
}

<?php

declare(strict_types=1);

namespace SocialPost\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use JsonException;
use SocialPost\Exception\InvalidTokenException;

/**
 * Class FictionalClient
 *
 * @package SocialPost\Client
 */
class FictionalClient implements SocialClientInterface
{

    /**
     * @var string
     */
    private string $clientId;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * FictionalSocialApiClient constructor.
     *
     * @param Client $client
     * @param string $clientId
     */
    public function __construct(Client $client, string $clientId)
    {
        $this->clientId = $clientId;
        $this->client   = $client;
    }

    /**
     * @param string $url
     * @param array  $parameters
     *
     * @return string
     * @throws GuzzleException
     */
    public function get(string $url, array $parameters): string
    {
        return $this->request('GET', $url, [], $parameters);
    }

    /**
     * @param string $url
     * @param array  $body
     *
     * @return string
     * @throws GuzzleException
     */
    public function post(string $url, array $body): string
    {
        $headers = ['Content-Type' => 'application/json'];

        return $this->request('POST', $url, $headers, [], $body);
    }

    /**
     * @param string $url
     * @param array  $body
     *
     * @return string
     * @throws GuzzleException
     */
    public function authRequest(string $url, array $body): string
    {
        $body['client_id'] = $this->clientId;

        return $this->post($url, $body);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $headers
     * @param array $parameters
     * @param array $body
     *
     * @return string
     * @throws GuzzleException
     * @throws JsonException
     */
    protected function request(string $method, string $url, array $headers, array $parameters, array $body = []): string
    {
        if (!empty($parameters)) {
            $url = sprintf('%s?%s', $url, http_build_query($parameters));
        }

        $encodedBody = empty($body) ? null : json_encode($body, JSON_THROW_ON_ERROR);

        $request = new Request($method, $url, $headers, $encodedBody);

        try {
            $response = $this->client->send($request);
        } catch (ServerException $exception) {
            if ($this->isTokenInvalid($exception)) {
                throw new InvalidTokenException();
            }

            throw $exception;
        }

        return $response->getBody()->getContents();
    }

    /**
     * @param ServerException $exception
     *
     * @return bool
     */
    protected function isTokenInvalid(ServerException $exception): bool
    {
        $response = \GuzzleHttp\json_decode(
            $exception->getResponse()->getBody()->getContents(),
            true
        );

        return !(!isset($response['error']['message']) || 'Invalid SL Token' !== $response['error']['message']);
    }
}

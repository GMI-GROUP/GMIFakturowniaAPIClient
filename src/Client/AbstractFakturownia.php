<?php

namespace Gmigroup\Clients\Fakturownia\Client;

use Gmigroup\Clients\Fakturownia\Exception\InvalidTokenException;
use Gmigroup\Clients\Fakturownia\Mapping\Mapping;
use Gmigroup\Clients\Fakturownia\Response\FakturowniaResponse;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\RequestInterface;

abstract class AbstractFakturownia
{
    public const GET_METHOD = 'GET';

    /**
     * @var string
     */
    protected $apiToken;

    /**
     * @var string
     */
    protected $baseUrl = 'https://{USERNAME}.fakturownia.pl/';

    /**
     * @var ClientInterface
     */
    protected $guzzle;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var array
     */
    protected $queryParams = [];

    public function __construct(ClientInterface $guzzle, string $apiToken)
    {
        $this->guzzle = $guzzle;

        $this->validToken($apiToken);
        $this->apiToken = $apiToken;

        $apiUsername = explode('/', $apiToken)[1];

        $this->baseUrl = str_replace('{USERNAME}', $apiUsername, $this->baseUrl);

        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }

    private function validToken(string $apiToken): void
    {
        $isValid = (bool) preg_match('~^[^/]+/[^/]+$~', $apiToken);

        if (!$isValid) {
            throw new InvalidTokenException();
        }
    }

    private function client(): ClientInterface
    {
        return $this->guzzle->setBaseUrl($this->baseUrl);
    }

    public function request(string $apiMethod, int $id = 0, array $data = []): FakturowniaResponse
    {
        if (!isset(Mapping::ALL_METHODS[$apiMethod])) {
            throw new \InvalidArgumentException(sprintf('Unsupported API method: %s', $apiMethod));
        }

        $requestMethod = $this->mapApiMethodsToRequestMethod($apiMethod);

        $queryParams = [];

        if (RequestInterface::GET === $requestMethod) {
            $queryParams = [
                'api_token' => $this->apiToken,
            ];
        }

        $uri = $this->prepateUrl($apiMethod, $id, $queryParams);

        $body = [];

        $request = $this->client()->createRequest(
            $requestMethod,
            $uri,
            $this->headers,
            !empty($body) ? $body : null
        );

        $response = $this->client()->send($request);

        return new FakturowniaResponse($response->getStatusCode(), json_decode($response->getBody(true), true));
    }

    protected function prepateUrl(string $apiMethod, int $id, array $queryParams = [])
    {
        $uri = sprintf('%s%s', $this->baseUrl, Mapping::ALL_METHODS[$apiMethod]);
        if (!empty($queryParams)) {
            $uri = sprintf('%s?%s', $uri, http_build_query($queryParams));
        }
        return $uri;
    }

    /**
     * @param string $apiMethod
     * @return string
     */
    protected function mapApiMethodsToRequestMethod(string $apiMethod): string
    {
        $prefixMethod = preg_replace('/^([a-z]+).+$/', '$1', $apiMethod);

        switch ($prefixMethod) {
            case 'get':
                return RequestInterface::GET;
            case 'create':
                return RequestInterface::POST;
            case 'delete':
                return RequestInterface::DELETE;
            default:
                throw new \InvalidArgumentException('Undefined request method: ' . $apiMethod);
        }
    }
}

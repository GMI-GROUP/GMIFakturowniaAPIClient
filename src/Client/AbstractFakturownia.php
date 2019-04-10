<?php

namespace Gmigroup\Clients\Fakturownia\Client;

use Gmigroup\Clients\Fakturownia\Exception\InvalidTokenException;
use Gmigroup\Clients\Fakturownia\Mapping\Mapping;
use Gmigroup\Clients\Fakturownia\Response\FakturowniaResponse;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;

abstract class AbstractFakturownia
{
    public const GET_METHOD = 'GET';
    public const POST_METHOD = 'POST';
    public const DELETE_METHOD = 'DELETE';

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
        return $this->guzzle;
    }

    public function request(string $apiMethod, int $id = 0, array $data = []): FakturowniaResponse
    {
        if (!isset(Mapping::ALL_METHODS[$apiMethod])) {
            throw new \InvalidArgumentException(sprintf('Unsupported API method: %s', $apiMethod));
        }

        $requestMethod = $this->mapApiMethodsToRequestMethod($apiMethod);

        $queryParams = [];
        $body = [];

        if (self::GET_METHOD === $requestMethod) {
            $queryParams = [
                'api_token' => $this->apiToken,
            ];
        } else {
            $body['api_token'] = $this->apiToken;
            $body = array_merge($body, $data);
        }

        $uri = $this->prepateUrl($apiMethod, $id, $queryParams);

        $options = [
            'headers' => $this->headers,
        ];

        if (!empty($body)) {
            $options[RequestOptions::JSON] = $body;
        }

        $response = $this->client()->request(
            $requestMethod,
            $uri,
            $options
        );

        return new FakturowniaResponse($response->getStatusCode(), json_decode($response->getBody(), true));
    }

    protected function prepateUrl(string $apiMethod, int $id, array $queryParams = []): string
    {
        $uri = sprintf('%s%s', $this->baseUrl, Mapping::ALL_METHODS[$apiMethod]);
        if (!empty($queryParams)) {
            $uri = sprintf('%s?%s', $uri, http_build_query($queryParams));
        }
        if (!empty($id)) {
            $uri = str_replace('[ID]', $id, $uri);
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
                return self::GET_METHOD;
            case 'create':
                return self::POST_METHOD;
            case 'delete':
                return self::DELETE_METHOD;
            default:
                throw new \InvalidArgumentException('Undefined request method: ' . $apiMethod);
        }
    }
}

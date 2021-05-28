<?php

declare(strict_types=1);

namespace Wimski\HttpClient;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Wimski\HttpClient\Contracts\HttpClientInterface;
use Wimski\HttpClient\Contracts\RequestData\BodyRequestDataInterface;
use Wimski\HttpClient\Contracts\RequestData\HeaderRequestDataInterface;
use Wimski\HttpClient\Contracts\RequestData\QueryRequestDataInterface;
use Wimski\HttpClient\Enums\HttpRequestMethodEnum;

class HttpClient implements HttpClientInterface
{
    protected ClientInterface $client;
    protected UriFactoryInterface $uriFactory;
    protected RequestFactoryInterface $requestFactory;
    protected StreamFactoryInterface $streamFactory;

    public function __construct(
        ClientInterface $client,
        UriFactoryInterface $uriFactory,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->client         = $client;
        $this->uriFactory     = $uriFactory;
        $this->requestFactory = $requestFactory;
        $this->streamFactory  = $streamFactory;
    }

    public function request(
        HttpRequestMethodEnum $method,
        string $uri,
        BodyRequestDataInterface $body = null,
        QueryRequestDataInterface $query = null,
        HeaderRequestDataInterface $headers = null
    ): ResponseInterface {
        $request = $this->createRequest($method, $uri, $body, $query, $headers);

        return $this->client->sendRequest($request);
    }

    public function get(
        string $uri,
        QueryRequestDataInterface $query = null,
        HeaderRequestDataInterface $headers = null
    ): ResponseInterface {
        return $this->request(HttpRequestMethodEnum::GET(), $uri, null, $query, $headers);
    }

    public function post(
        string $uri,
        BodyRequestDataInterface $body,
        QueryRequestDataInterface $query = null,
        HeaderRequestDataInterface $headers = null
    ): ResponseInterface {
        return $this->request(HttpRequestMethodEnum::POST(), $uri, $body, $query, $headers);
    }

    public function put(
        string $uri,
        BodyRequestDataInterface $body,
        QueryRequestDataInterface $query = null,
        HeaderRequestDataInterface $headers = null
    ): ResponseInterface {
        return $this->request(HttpRequestMethodEnum::PUT(), $uri, $body, $query, $headers);
    }

    public function delete(
        string $uri,
        QueryRequestDataInterface $query = null,
        HeaderRequestDataInterface $headers = null
    ): ResponseInterface {
        return $this->request(HttpRequestMethodEnum::DELETE(), $uri, null, $query, $headers);
    }

    protected function createRequest(
        HttpRequestMethodEnum $method,
        string $uri,
        BodyRequestDataInterface $body = null,
        QueryRequestDataInterface $query = null,
        HeaderRequestDataInterface $headers = null
    ): RequestInterface {
        $request = $this->requestFactory->createRequest(
            $method->getValue(),
            $this->processUri($uri, $query),
        );

        if ($method->supportsRequestBody()) {
            $request = $this->addRequestBody($request, $body);
        }

        return $this->addRequestHeaders($request, $headers);
    }

    protected function processUri(string $uri, QueryRequestDataInterface $query = null): UriInterface
    {
        $uriInterface = $this->uriFactory->createUri($uri);

        if (! $query) {
            return $uriInterface;
        }

        return $uriInterface->withQuery(http_build_query($query->all()));
    }

    protected function addRequestBody(RequestInterface $request, BodyRequestDataInterface $body = null): RequestInterface
    {
        if (! $body) {
            return $request;
        }

        $stream = $this->streamFactory->createStream(
            json_encode($body->all()),
        );

        return $request->withBody($stream);
    }

    protected function addRequestHeaders(
        RequestInterface $request,
        HeaderRequestDataInterface $headers = null
    ): RequestInterface {
        if (! $headers) {
            return $request;
        }

        foreach ($headers->all() as $name => $value) {
            $request = $request->withAddedHeader($name, $value);
        }

        return $request;
    }
}

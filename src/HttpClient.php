<?php

declare(strict_types=1);

namespace Wimski\HttpClient;

use InvalidArgumentException;
use JsonException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Throwable;
use Wimski\HttpClient\Contracts\HttpClientInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestBodyDataInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestHeaderDataInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestQueryDataInterface;
use Wimski\HttpClient\Enums\HttpRequestMethodEnum;
use Wimski\HttpClient\Exceptions\CreatingRequestException;
use Wimski\HttpClient\Exceptions\SendingRequestException;

class HttpClient implements HttpClientInterface
{
    protected ?RequestHeaderDataInterface $defaultHeaders = null;
    protected ?string $baseUri = null;

    public function __construct(
        protected ClientInterface $client,
        protected UriFactoryInterface $uriFactory,
        protected RequestFactoryInterface $requestFactory,
        protected StreamFactoryInterface $streamFactory,
    ) {
    }

    public function setBaseUri(?string $baseUri): HttpClientInterface
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    public function setDefaultHeaders(RequestHeaderDataInterface $headers): HttpClientInterface
    {
        $this->defaultHeaders = $headers;

        return $this;
    }

    public function request(
        HttpRequestMethodEnum $method,
        string $uri,
        ?RequestBodyDataInterface $body = null,
        ?RequestQueryDataInterface $query = null,
        ?RequestHeaderDataInterface $headers = null,
    ): ResponseInterface {
        try {
            $request = $this->createRequest($method, $uri, $body, $query, $headers);
        } catch (Throwable $exception) {
            throw new CreatingRequestException(
                $exception,
                $method,
                $uri,
                $body,
                $query,
                $headers,
            );
        }

        try {
            return $this->client->sendRequest($request);
        } catch (Throwable $exception) {
            throw new SendingRequestException(
                $exception,
                $method,
                $uri,
                $body,
                $query,
                $headers,
            );
        }
    }

    public function get(
        string $uri,
        ?RequestQueryDataInterface $query = null,
        ?RequestHeaderDataInterface $headers = null,
    ): ResponseInterface {
        return $this->request(HttpRequestMethodEnum::GET(), $uri, null, $query, $headers);
    }

    public function post(
        string $uri,
        RequestBodyDataInterface $body,
        ?RequestQueryDataInterface $query = null,
        ?RequestHeaderDataInterface $headers = null,
    ): ResponseInterface {
        return $this->request(HttpRequestMethodEnum::POST(), $uri, $body, $query, $headers);
    }

    public function put(
        string $uri,
        RequestBodyDataInterface $body,
        ?RequestQueryDataInterface $query = null,
        ?RequestHeaderDataInterface $headers = null,
    ): ResponseInterface {
        return $this->request(HttpRequestMethodEnum::PUT(), $uri, $body, $query, $headers);
    }

    public function  delete(
        string $uri,
        ?RequestQueryDataInterface $query = null,
        ?RequestHeaderDataInterface $headers = null,
    ): ResponseInterface {
        return $this->request(HttpRequestMethodEnum::DELETE(), $uri, null, $query, $headers);
    }

    /**
     * @param HttpRequestMethodEnum           $method
     * @param string                          $uri
     * @param RequestBodyDataInterface|null   $body
     * @param RequestQueryDataInterface|null  $query
     * @param RequestHeaderDataInterface|null $headers
     * @return RequestInterface
     * @throws InvalidArgumentException|JsonException
     */
    protected function createRequest(
        HttpRequestMethodEnum $method,
        string $uri,
        ?RequestBodyDataInterface $body = null,
        ?RequestQueryDataInterface $query = null,
        ?RequestHeaderDataInterface $headers = null,
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

    /**
     * @param string                         $uri
     * @param RequestQueryDataInterface|null $query
     * @return UriInterface
     * @throws InvalidArgumentException
     */
    protected function processUri(string $uri, RequestQueryDataInterface $query = null): UriInterface
    {
        if (! $this->baseUri || preg_match('/^https?:\/\//', $uri) === 1) {
            $requestUri = $uri;
        } else {
            $requestUri = rtrim($this->baseUri, '/') . trim($uri, '/');
        }

        $uriInterface = $this->uriFactory->createUri($requestUri);

        if (! $query) {
            return $uriInterface;
        }

        return $uriInterface->withQuery(http_build_query($query->all()));
    }

    /**
     * @param RequestInterface              $request
     * @param RequestBodyDataInterface|null $body
     * @return RequestInterface
     * @throws InvalidArgumentException|JsonException
     */
    protected function addRequestBody(
        RequestInterface $request,
        RequestBodyDataInterface $body = null,
    ): RequestInterface {
        if (! $body) {
            return $request;
        }

        $stream = $this->streamFactory->createStream(
            json_encode($body->all(), JSON_THROW_ON_ERROR),
        );

        return $request->withBody($stream);
    }

    /**
     * @param RequestInterface                $request
     * @param RequestHeaderDataInterface|null $headers
     * @return RequestInterface
     * @throws InvalidArgumentException
     */
    protected function addRequestHeaders(
        RequestInterface $request,
        RequestHeaderDataInterface $headers = null
    ): RequestInterface {
        $requestHeaders = null;

        if ($headers) {
            $requestHeaders = $headers;
        }

        if ($this->defaultHeaders) {
            $requestHeaders = $headers
                ? $this->defaultHeaders->merge($headers)
                : $this->defaultHeaders;
        }

        if (! $requestHeaders) {
            return $request;
        }

        foreach ($requestHeaders->all() as $name => $value) {
            $request = $request->withAddedHeader($name, $value);
        }

        return $request;
    }
}

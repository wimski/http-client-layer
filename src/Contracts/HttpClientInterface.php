<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Contracts;

use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestBodyDataInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestHeaderDataInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestQueryDataInterface;
use Wimski\HttpClient\Enums\HttpRequestMethodEnum;

interface HttpClientInterface
{
    public function setBaseUri(string $baseUri): HttpClientInterface;
    public function setDefaultHeaders(RequestHeaderDataInterface $headers): HttpClientInterface;

    /**
     * @param HttpRequestMethodEnum           $method
     * @param string                          $uri
     * @param RequestBodyDataInterface|null   $body
     * @param RequestQueryDataInterface|null  $query
     * @param RequestHeaderDataInterface|null $headers
     * @return ResponseInterface
     * @throws RequestExceptionInterface
     */
    public function request(
        HttpRequestMethodEnum $method,
        string $uri,
        ?RequestBodyDataInterface $body = null,
        ?RequestQueryDataInterface $query = null,
        ?RequestHeaderDataInterface $headers = null,
    ): ResponseInterface;

    /**
     * @param string                          $uri
     * @param RequestQueryDataInterface|null  $query
     * @param RequestHeaderDataInterface|null $headers
     * @return ResponseInterface
     * @throws RequestExceptionInterface
     */
    public function get(
        string $uri,
        ?RequestQueryDataInterface $query = null,
        ?RequestHeaderDataInterface $headers = null,
    ): ResponseInterface;

    /**
     * @param string                          $uri
     * @param RequestBodyDataInterface        $body
     * @param RequestQueryDataInterface|null  $query
     * @param RequestHeaderDataInterface|null $headers
     * @return ResponseInterface
     * @throws RequestExceptionInterface
     */
    public function post(
        string $uri,
        RequestBodyDataInterface $body,
        ?RequestQueryDataInterface $query = null,
        ?RequestHeaderDataInterface $headers = null,
    ): ResponseInterface;

    /**
     * @param string                          $uri
     * @param RequestBodyDataInterface        $body
     * @param RequestQueryDataInterface|null  $query
     * @param RequestHeaderDataInterface|null $headers
     * @return ResponseInterface
     * @throws RequestExceptionInterface
     */
    public function put(
        string $uri,
        RequestBodyDataInterface $body,
        ?RequestQueryDataInterface $query = null,
        ?RequestHeaderDataInterface $headers = null,
    ): ResponseInterface;

    /**
     * @param string                          $uri
     * @param RequestQueryDataInterface|null  $query
     * @param RequestHeaderDataInterface|null $headers
     * @return ResponseInterface
     * @throws RequestExceptionInterface
     */
    public function delete(
        string $uri,
        ?RequestQueryDataInterface $query = null,
        ?RequestHeaderDataInterface $headers = null,
    ): ResponseInterface;
}

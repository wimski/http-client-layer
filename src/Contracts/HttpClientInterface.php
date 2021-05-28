<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Contracts;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Wimski\HttpClient\Contracts\RequestData\BodyRequestDataInterface;
use Wimski\HttpClient\Contracts\RequestData\HeaderRequestDataInterface;
use Wimski\HttpClient\Contracts\RequestData\QueryRequestDataInterface;
use Wimski\HttpClient\Enums\HttpRequestMethodEnum;

interface HttpClientInterface
{
    public function setDefaultHeaders(HeaderRequestDataInterface $headers): HttpClientInterface;

    /**
     * @param HttpRequestMethodEnum           $method
     * @param string                          $uri
     * @param BodyRequestDataInterface|null   $body
     * @param QueryRequestDataInterface|null  $query
     * @param HeaderRequestDataInterface|null $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function request(
        HttpRequestMethodEnum $method,
        string $uri,
        BodyRequestDataInterface $body = null,
        QueryRequestDataInterface $query = null,
        HeaderRequestDataInterface $headers = null
    ): ResponseInterface;

    /**
     * @param string                          $uri
     * @param QueryRequestDataInterface|null  $query
     * @param HeaderRequestDataInterface|null $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function get(
        string $uri,
        QueryRequestDataInterface $query = null,
        HeaderRequestDataInterface $headers = null
    ): ResponseInterface;

    /**
     * @param string                          $uri
     * @param BodyRequestDataInterface        $body
     * @param QueryRequestDataInterface|null  $query
     * @param HeaderRequestDataInterface|null $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function post(
        string $uri,
        BodyRequestDataInterface $body,
        QueryRequestDataInterface $query = null,
        HeaderRequestDataInterface $headers = null
    ): ResponseInterface;

    /**
     * @param string                          $uri
     * @param BodyRequestDataInterface        $body
     * @param QueryRequestDataInterface|null  $query
     * @param HeaderRequestDataInterface|null $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function put(
        string $uri,
        BodyRequestDataInterface $body,
        QueryRequestDataInterface $query = null,
        HeaderRequestDataInterface $headers = null
    ): ResponseInterface;

    /**
     * @param string                          $uri
     * @param QueryRequestDataInterface|null  $query
     * @param HeaderRequestDataInterface|null $headers
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function delete(
        string $uri,
        QueryRequestDataInterface $query = null,
        HeaderRequestDataInterface $headers = null
    ): ResponseInterface;
}

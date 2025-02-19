<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Exceptions;

use Exception;
use Throwable;
use Wimski\HttpClient\Contracts\RequestData\RequestBodyDataInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestHeaderDataInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestQueryDataInterface;
use Wimski\HttpClient\Enums\HttpRequestMethodEnum;

abstract class AbstractRequestException extends Exception
{
    public function __construct(
        string $message,
        Throwable $exception,
        protected HttpRequestMethodEnum $method,
        protected string $uri,
        protected ?RequestBodyDataInterface $body,
        protected ?RequestQueryDataInterface $query,
        protected ?RequestHeaderDataInterface $headers,
    ) {
        parent::__construct($message, $exception->getCode(), $exception);
    }

    public function getMethod(): HttpRequestMethodEnum
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getBody(): ?RequestBodyDataInterface
    {
        return $this->body;
    }

    public function getQuery(): ?RequestQueryDataInterface
    {
        return $this->query;
    }

    public function getHeaders(): ?RequestHeaderDataInterface
    {
        return $this->headers;
    }
}

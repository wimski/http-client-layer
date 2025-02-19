<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Exceptions;

use Throwable;
use Wimski\HttpClient\Contracts\Exceptions\RequestExceptionInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestBodyDataInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestHeaderDataInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestQueryDataInterface;
use Wimski\HttpClient\Enums\HttpRequestMethodEnum;

class CreatingRequestException extends AbstractRequestException implements RequestExceptionInterface
{
    public function __construct(
        Throwable $exception,
        HttpRequestMethodEnum $method,
        string $uri,
        ?RequestBodyDataInterface $body = null,
        ?RequestQueryDataInterface $query = null,
        ?RequestHeaderDataInterface $headers = null,
    ) {
        parent::__construct(
            'Creating request failed',
            $exception,
            $method,
            $uri,
            $body,
            $query,
            $headers,
        );
    }
}
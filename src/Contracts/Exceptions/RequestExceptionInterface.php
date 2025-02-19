<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Contracts\Exceptions;

use Wimski\HttpClient\Contracts\RequestData\RequestBodyDataInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestHeaderDataInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestQueryDataInterface;
use Wimski\HttpClient\Enums\HttpRequestMethodEnum;

interface RequestExceptionInterface
{
    public function getMethod(): HttpRequestMethodEnum;
    public function getUri(): string;
    public function getBody(): ?RequestBodyDataInterface;
    public function getQuery(): ?RequestQueryDataInterface;
    public function getHeaders(): ?RequestHeaderDataInterface;
}

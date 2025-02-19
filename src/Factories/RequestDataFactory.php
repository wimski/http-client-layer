<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Factories;

use Wimski\HttpClient\Contracts\Factories\RequestDataFactoryInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestBodyDataInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestHeaderDataInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestQueryDataInterface;
use Wimski\HttpClient\RequestData\RequestBodyData;
use Wimski\HttpClient\RequestData\RequestHeaderData;
use Wimski\HttpClient\RequestData\RequestQueryData;

class RequestDataFactory implements RequestDataFactoryInterface
{
    public function makeBodyData(array $data = null): RequestBodyDataInterface
    {
        return new RequestBodyData($data ?? []);
    }

    public function makeHeaderData(array $data = null): RequestHeaderDataInterface
    {
        return new RequestHeaderData($data ?? []);
    }

    public function makeQueryData(array $data = null): RequestQueryDataInterface
    {
        return new RequestQueryData($data ?? []);
    }
}

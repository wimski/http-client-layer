<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Contracts\Factories;

use Wimski\HttpClient\Contracts\RequestData\RequestBodyDataInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestHeaderDataInterface;
use Wimski\HttpClient\Contracts\RequestData\RequestQueryDataInterface;

interface RequestDataFactoryInterface
{
    /**
     * @param array<string, mixed> $data
     * @return RequestBodyDataInterface
     */
    public function makeBodyData(array $data = null): RequestBodyDataInterface;

    /**
     * @param array<string, string> $data
     * @return RequestHeaderDataInterface
     */
    public function makeHeaderData(array $data = null): RequestHeaderDataInterface;

    /**
     * @param array<string, mixed> $data
     * @return RequestQueryDataInterface
     */
    public function makeQueryData(array $data = null): RequestQueryDataInterface;
}

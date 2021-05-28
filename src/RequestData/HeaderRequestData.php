<?php

declare(strict_types=1);

namespace Wimski\HttpClient\RequestData;

use Wimski\HttpClient\Contracts\RequestData\HeaderRequestDataInterface;

class HeaderRequestData extends AbstractRequestData implements HeaderRequestDataInterface
{
    public static function make(array $parameters = null): HeaderRequestDataInterface
    {
        return new self($parameters);
    }
}

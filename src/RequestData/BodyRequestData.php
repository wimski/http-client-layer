<?php

declare(strict_types=1);

namespace Wimski\HttpClient\RequestData;

use Wimski\HttpClient\Contracts\RequestData\BodyRequestDataInterface;

class BodyRequestData extends AbstractRequestData implements BodyRequestDataInterface
{
    public static function make(array $parameters = null): BodyRequestDataInterface
    {
        return new self($parameters);
    }
}

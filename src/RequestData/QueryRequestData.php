<?php

declare(strict_types=1);

namespace Wimski\HttpClient\RequestData;

use Wimski\HttpClient\Contracts\RequestData\QueryRequestDataInterface;

class QueryRequestData extends AbstractRequestData implements QueryRequestDataInterface
{
    public static function make(array $parameters = null): QueryRequestDataInterface
    {
        return new self($parameters);
    }
}

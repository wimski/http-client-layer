<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Contracts\RequestData;

interface QueryRequestDataInterface extends RequestDataInterface
{
    /**
     * @var array<string, mixed> $parameters
     * @return QueryRequestDataInterface
     */
    public static function make(array $parameters = null): QueryRequestDataInterface;

    /**
     * @param string $key
     * @param mixed  $value
     * @return QueryRequestDataInterface
     */
    public function add(string $key, $value);

    /**
     * @param array<string, mixed> $parameters
     * @return QueryRequestDataInterface
     */
    public function set(array $parameters);
}

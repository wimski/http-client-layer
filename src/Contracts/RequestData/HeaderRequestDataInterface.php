<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Contracts\RequestData;

interface HeaderRequestDataInterface extends RequestDataInterface
{
    /**
     * @var array<string, mixed> $parameters
     * @return HeaderRequestDataInterface
     */
    public static function make(array $parameters = null);

    /**
     * @param string $key
     * @param mixed  $value
     * @return HeaderRequestDataInterface
     */
    public function add(string $key, $value);

    /**
     * @param array<string, mixed> $parameters
     * @return HeaderRequestDataInterface
     */
    public function set(array $parameters);

    /**
     * @param HeaderRequestDataInterface ...$requestData
     * @return HeaderRequestDataInterface
     */
    public function merge(...$requestData);
}

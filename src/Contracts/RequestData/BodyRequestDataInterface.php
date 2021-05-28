<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Contracts\RequestData;

interface BodyRequestDataInterface extends RequestDataInterface
{
    /**
     * @var array<string, mixed> $parameters
     * @return BodyRequestDataInterface
     */
    public static function make(array $parameters = null): BodyRequestDataInterface;

    /**
     * @param string $key
     * @param mixed  $value
     * @return BodyRequestDataInterface
     */
    public function add(string $key, $value);

    /**
     * @param array<string, mixed> $parameters
     * @return BodyRequestDataInterface
     */
    public function set(array $parameters);
}

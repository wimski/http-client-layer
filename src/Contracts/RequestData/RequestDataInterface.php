<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Contracts\RequestData;

interface RequestDataInterface
{
    /**
     * @param array<string, mixed>|null $parameters
     */
    public function __construct(array $parameters = null);

    /**
     * @var array<string, mixed> $parameters
     * @return RequestDataInterface
     */
    public static function make(array $parameters = null);

    /**
     * @param string $key
     * @param mixed  $value
     * @return RequestDataInterface
     */
    public function add(string $key, $value);

    /**
     * @param array<string, mixed> $parameters
     * @return RequestDataInterface
     */
    public function set(array $parameters);

    /**
     * @param RequestDataInterface ...$requestData
     * @return RequestDataInterface
     */
    public function merge(...$requestData);

    public function has(string $key): bool;

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key);

    /**
     * @return array<string, mixed>
     */
    public function all(): array;
}

<?php

declare(strict_types=1);

namespace Wimski\HttpClient\RequestData;

use Wimski\HttpClient\Contracts\RequestData\RequestDataInterface;

abstract class AbstractRequestData implements RequestDataInterface
{
    /**
     * @var array<string, mixed>
     */
    protected array $parameters;

    public function __construct(array $parameters = null)
    {
        $this->parameters = $parameters ?? [];
    }

    public static function make(array $parameters = null)
    {
        return new static($parameters);
    }

    public function add(string $key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    public function set(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function merge(...$requestData)
    {
        $data = array_map(function (RequestDataInterface $requestData): array {
            return $requestData->all();
        }, $requestData);

        return static::make(array_merge_recursive(
            $this->all(),
            ...$data,
        ));
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->parameters);
    }

    public function get(string $key)
    {
        return $this->has($key)
            ? $this->parameters[$key]
            : null;
    }

    public function all(): array
    {
        return $this->parameters;
    }
}

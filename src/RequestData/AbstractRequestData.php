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

    public function get(string $key)
    {
        if (array_key_exists($key, $this->parameters)) {
            return $this->parameters[$key];
        }

        return null;
    }

    public function all(): array
    {
        return $this->parameters;
    }
}

<?php

declare(strict_types=1);

namespace Wimski\HttpClient\RequestData;

use Wimski\HttpClient\Contracts\RequestData\RequestQueryDataInterface;

class RequestQueryData implements RequestQueryDataInterface
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        protected array $data = [],
    ) {
    }

    public function add(string $key, mixed $value): RequestQueryDataInterface
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function set(array $data): RequestQueryDataInterface
    {
        $this->data = $data;

        return $this;
    }

    public function merge(RequestQueryDataInterface ...$queryData): RequestQueryDataInterface
    {
        $data = array_map(function (RequestQueryDataInterface $requestData): array {
            return $requestData->all();
        }, $queryData);

        return new self(array_merge_recursive(
            $this->all(),
            ...$data,
        ));
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function get(string $key): mixed
    {
        return $this->has($key)
            ? $this->data[$key]
            : null;
    }

    public function all(): array
    {
        return $this->data;
    }
}

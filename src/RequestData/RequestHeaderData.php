<?php

declare(strict_types=1);

namespace Wimski\HttpClient\RequestData;

use Wimski\HttpClient\Contracts\RequestData\RequestHeaderDataInterface;

class RequestHeaderData implements RequestHeaderDataInterface
{
    /**
     * @param array<string, string> $data
     */
    public function __construct(
        protected array $data = [],
    ) {
    }

    public function add(string $key, string $value): RequestHeaderDataInterface
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function set(array $data): RequestHeaderDataInterface
    {
        $this->data = $data;

        return $this;
    }

    public function merge(RequestHeaderDataInterface ...$headerData): RequestHeaderDataInterface
    {
        $data = array_map(function (RequestHeaderDataInterface $requestData): array {
            return $requestData->all();
        }, $headerData);

        return new self(array_merge_recursive(
            $this->all(),
            ...$data,
        ));
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function get(string $key): ?string
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

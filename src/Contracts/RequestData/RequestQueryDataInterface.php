<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Contracts\RequestData;

interface RequestQueryDataInterface
{
    public function add(string $key, mixed $value): RequestQueryDataInterface;

    /**
     * @param array<string, mixed> $data
     * @return RequestQueryDataInterface
     */
    public function set(array $data): RequestQueryDataInterface;

    public function merge(RequestQueryDataInterface ...$queryData): RequestQueryDataInterface;

    public function has(string $key): bool;

    public function get(string $key): mixed;

    /**
     * @return array<string, mixed>
     */
    public function all(): array;
}

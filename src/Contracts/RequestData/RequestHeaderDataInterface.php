<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Contracts\RequestData;

interface RequestHeaderDataInterface
{
    public function add(string $key, string $value): RequestHeaderDataInterface;

    /**
     * @param array<string, string> $data
     * @return RequestHeaderDataInterface
     */
    public function set(array $data): RequestHeaderDataInterface;

    public function merge(RequestHeaderDataInterface ...$headerData): RequestHeaderDataInterface;

    public function has(string $key): bool;

    public function get(string $key): ?string;

    /**
     * @return array<string, string>
     */
    public function all(): array;
}

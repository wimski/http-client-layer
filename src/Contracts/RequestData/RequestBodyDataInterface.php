<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Contracts\RequestData;

interface RequestBodyDataInterface
{
    public function add(string $key, mixed $value): RequestBodyDataInterface;

    /**
     * @param array<string, mixed> $data
     * @return RequestBodyDataInterface
     */
    public function set(array $data): RequestBodyDataInterface;

    public function merge(RequestBodyDataInterface ...$bodyData): RequestBodyDataInterface;

    public function has(string $key): bool;

    public function get(string $key): mixed;

    /**
     * @return array<string, mixed>
     */
    public function all(): array;
}

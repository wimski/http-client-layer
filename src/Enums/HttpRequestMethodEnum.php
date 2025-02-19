<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Enums;

use MyCLabs\Enum\Enum;

/**
 * @extends Enum<string>
 * @method static self DELETE()
 * @method static self GET()
 * @method static self POST()
 * @method static self PUT()
 */
class HttpRequestMethodEnum extends Enum
{
    public const DELETE = 'DELETE';
    public const GET    = 'GET';
    public const POST   = 'POST';
    public const PUT    = 'PUT';

    public function supportsRequestBody(): bool
    {
        return $this->equals(static::POST())
            || $this->equals(static::PUT());
    }
}

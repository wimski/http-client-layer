<?php

declare(strict_types=1);

namespace Wimski\HttpClient\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static static DELETE()
 * @method static static GET()
 * @method static static POST()
 * @method static static PUT()
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

<?php

declare(strict_types=1);

namespace App\Http\Enums;

/**
 * Enum Roles
 */
enum Roles: int
{
    /**
     * @type integer
     */
    case ADMIN = 1;

    /**
     * @type integer
     */
    case USER = 2;

    /**
     * @type integer
     */
    case SUPER_ADMIN = 3;
}

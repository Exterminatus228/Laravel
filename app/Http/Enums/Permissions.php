<?php

declare(strict_types=1);

namespace App\Http\Enums;

/**
 * Enum Permissions
 */
enum Permissions: int
{
    /**
     * @type integer
     */
    case CAN_CREATE_USERS = 1;
}

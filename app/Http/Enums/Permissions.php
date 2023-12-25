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

    /**
     * @type integer
     */
    case CAN_UPDATE_USERS = 2;

    /**
     * @type integer
     */
    case CAN_DELETE_USERS = 3;
}

<?php

declare(strict_types=1);

namespace App\Policies;

use App\Http\Enums\Permissions;
use App\Http\Enums\Roles;
use App\Models\User;

/**
 * Class UserPolicy
 */
class UserPolicy
{
    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasRoles([Roles::SUPER_ADMIN])
            || $user->hasPermissions([Permissions::CAN_CREATE_USERS]);
    }

    /**
     * @param User $user
     * @param User $updateUser
     * @return bool
     */
    public function update(User $user, User $updateUser): bool
    {
        return $user->id === $updateUser->id
            || $user->hasRoles([Roles::SUPER_ADMIN])
            || $user->hasPermissions([Permissions::CAN_CREATE_USERS]);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->hasRoles([Roles::SUPER_ADMIN])
            || $user->hasPermissions([Permissions::CAN_DELETE_USERS]);
    }
}

<?php

declare(strict_types=1);

namespace App\Policies;

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
        return $user->hasRoles([Roles::SUPER_ADMIN]);
    }
}

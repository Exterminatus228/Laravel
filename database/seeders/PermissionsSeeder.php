<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Http\Enums\Permissions;
use App\Http\Enums\Roles;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

/**
 * Class PermissionsSeeder
 */
class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [];

        foreach (Permissions::cases() as $case) {
            $permissions[$case->value] = Permission::query()->firstOrCreate(['type' => $case->value]);
        }

        $admin = Role::query()->where('type', '=', Roles::ADMIN->value)->first();

        if ($admin instanceof Role) {
            $rolePermissions = $admin->permissions()->get()->keyBy('type');
            $allowedPermissions = array_column(Permissions::cases(), 'value');
            $attachPermissions = [];

            foreach ($allowedPermissions as $permission) {
                if (empty($permissions[$permission])
                    || !empty($rolePermissions[$permission])
                ) {
                    continue;
                }

                $attachPermissions[] = $permissions[$permission];
            }

            $admin->permissions()->attach(array_column($attachPermissions, 'id'));
        }
    }
}

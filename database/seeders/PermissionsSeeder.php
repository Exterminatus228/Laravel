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
        $admin = Role::query()->where('type', '=', Roles::ADMIN->value)->first();

        if ($admin instanceof Role) {
            $allowedPermissions = [
                Permissions::CAN_CREATE_USERS
            ];
            foreach (array_column($allowedPermissions, 'value') as $type) {
                Permission::query()->firstOrCreate([
                    'role_id' => $admin->id,
                    'type' => $type,
                ]);
            }
        }
    }
}

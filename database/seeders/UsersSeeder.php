<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Http\Enums\Roles;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Throwable;

/**
 * Class UsersSeeder
 */
class UsersSeeder extends Seeder
{
    /**
     * @return void
     * @throws Throwable
     */
    public function run(): void
    {
        /**
         * @var User $superAdmin
         */
        $superAdmin = User::query()->firstOrCreate([
            'email' => 'exterminatus228228@gmail.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('ase3609ks'),
            'email_verified_at' => time(),
            'email' => 'exterminatus228228@gmail.com',
        ]);

        if (!$superAdmin->hasRoles([Roles::SUPER_ADMIN])) {
            /**
             * @var Role $superAdminRole
             */
            $superAdminRole = Role::query()->where('type', '=', Roles::SUPER_ADMIN->value)->firstOrFail();
            $superAdmin->roles()->attach([$superAdminRole->id]);
        }
    }
}

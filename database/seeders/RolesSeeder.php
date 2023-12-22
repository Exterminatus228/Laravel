<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Http\Enums\Roles;
use App\Models\Role;
use Illuminate\Database\Seeder;

/**
 * Class RolesSeeder
 */
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Roles::cases() as $case) {
            Role::query()->firstOrCreate(['type' => $case->value]);
        }
    }
}

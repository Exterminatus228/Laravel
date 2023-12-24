<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Http\DTO\Api\User\CreateUserDTO;
use App\Http\Enums\Roles;
use App\Http\Services\Api\User\UserServiceInterface;
use Illuminate\Database\Seeder;
use Throwable;

/**
 * Class UsersSeeder
 */
class UsersSeeder extends Seeder
{
    /**
     * @param UserServiceInterface $userService
     */
    public function __construct(
        private readonly UserServiceInterface $userService,
    ) {}

    /**
     * @return void
     * @throws Throwable
     */
    public function run(): void
    {
        $adminUser = new CreateUserDTO(
            'admin',
            'exterminatus228228@gmail.com',
            'ase3609ks',
            [Roles::SUPER_ADMIN],
        );
        $this->userService->createUser($adminUser);
    }
}

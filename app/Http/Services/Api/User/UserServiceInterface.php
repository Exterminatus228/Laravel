<?php

declare(strict_types=1);

namespace App\Http\Services\Api\User;

use App\Http\DTO\Api\User\CreateUserDTO;
use App\Http\DTO\Api\User\LoginDTO;
use App\Models\User;
use Throwable;

/**
 * Class UserServiceInterface
 */
interface UserServiceInterface
{
    /**
     * @type string
     */
    public const PERSONAL_TOKEN_KEY = 'personalToken';

    /**
     * @param CreateUserDTO $dto
     * @return User
     * @throws Throwable
     */
    public function createUser(CreateUserDTO $dto): User;

    /**
     * Returns token
     * @param LoginDTO $dto
     * @return string
     * @throws Throwable
     */
    public function login(LoginDTO $dto): string;
}

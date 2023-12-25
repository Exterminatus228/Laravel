<?php

declare(strict_types=1);

namespace App\Http\Services\Api\User;

use App\Http\DTO\Api\User\UpdateUserDTO;
use App\Http\DTO\Api\User\UserDTO;
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
     * @param int $id
     * @return User
     * @throws Throwable
     */
    public function confirm(int $id): User;

    /**
     * @param UserDTO $dto
     * @return User
     * @throws Throwable
     */
    public function create(UserDTO $dto): User;

    /**
     * @param UpdateUserDTO $dto
     * @return User
     * @throws Throwable
     */
    public function update(UpdateUserDTO $dto): User;

    /**
     * @param LoginDTO $dto
     * @return User
     * @throws Throwable
     */
    public function login(LoginDTO $dto): User;

    /**
     * @param int $id
     * @throws Throwable
     * @return void
     */
    public function delete(int $id): void;
}

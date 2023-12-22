<?php

declare(strict_types=1);

namespace App\Http\DTO\Api\User;

use App\Http\Enums\Roles;

/**
 * Class CreateUserDTO
 */
class CreateUserDTO
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param Roles $role
     */
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $password,
        private readonly Roles $role = Roles::USER
    ) {}

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return Roles
     */
    public function getRole(): Roles
    {
        return $this->role;
    }
}

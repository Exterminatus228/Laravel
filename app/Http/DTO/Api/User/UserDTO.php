<?php

declare(strict_types=1);

namespace App\Http\DTO\Api\User;

use App\Http\Enums\Roles;

/**
 * Class UserDTO
 */
class UserDTO
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param Roles[] $roles
     * @param bool $isEmailVerified
     */
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $password,
        private readonly array $roles = [Roles::USER],
        private readonly bool $isEmailVerified = false,
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
     * @return Roles[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return bool
     */
    public function isEmailVerified(): bool
    {
        return $this->isEmailVerified;
    }
}

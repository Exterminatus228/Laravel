<?php

declare(strict_types=1);

namespace App\Http\DTO\Api\User;

use App\Http\Enums\Roles;

/**
 * Class UpdateUserDTO
 */
class UpdateUserDTO
{
    /**
     * @param int $id
     * @param string|null $name
     * @param string|null $email
     * @param string|null $password
     * @param Roles[]|null $roles
     * @param bool|null $isEmailVerified
     */
    public function __construct(
        private readonly int $id,
        private readonly string|null $name = null,
        private readonly string|null $email = null,
        private readonly string|null $password = null,
        private readonly array|null $roles = null,
        private readonly bool|null $isEmailVerified = null,
    ) {}

    /**
     * @return string|null
     */
    public function getEmail(): string|null
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getName(): string|null
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getPassword(): string|null
    {
        return $this->password;
    }

    /**
     * @return Roles[]|null
     */
    public function getRoles(): array|null
    {
        return $this->roles;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool|null
     */
    public function isEmailVerified(): bool|null
    {
        return $this->isEmailVerified;
    }
}

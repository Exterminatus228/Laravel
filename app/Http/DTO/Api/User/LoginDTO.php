<?php

declare(strict_types=1);

namespace App\Http\DTO\Api\User;

/**
 * Class LoginDTO
 */
class LoginDTO
{
    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(
        private readonly string $email,
        private readonly string $password
    ) {}

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}

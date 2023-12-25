<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\User;

use App\Http\DTO\Api\User\UserDTO;
use App\Http\Enums\Roles;
use App\Http\Requests\Api\ApiRequest;

/**
 * Class SignUpRequest
 */
class SignUpRequest extends ApiRequest
{
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'max:255', 'confirmed'],
            'password_confirmation' => ['required'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function asObject(): UserDTO
    {
        return new UserDTO(
            (string)$this->input('name'),
            (string)$this->input('email'),
            (string)$this->input('password'),
            [Roles::USER]
        );
    }
}


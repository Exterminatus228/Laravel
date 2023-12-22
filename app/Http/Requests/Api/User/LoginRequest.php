<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\User;

use App\Http\DTO\Api\User\LoginDTO;
use App\Http\Requests\Api\ApiRequest;

/**
 * Class LoginRequest
 */
class LoginRequest extends ApiRequest
{
    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * @inheritDoc
     * @return LoginDTO
     */
    public function asObject(): LoginDTO
    {
        return new LoginDTO(
            (string)$this->input('email'),
            (string)$this->input('password'),
        );
    }
}

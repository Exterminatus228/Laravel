<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\User;

use App\Http\DTO\Api\User\CreateUserDTO;
use App\Http\Enums\Roles;
use App\Http\Requests\Api\ApiRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

/**
 * Class CreateRequest
 */
class CreateRequest extends ApiRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user instanceof User
            && $user->can('create', new User());
    }

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
            'role' => ['numeric', Rule::in(array_column(Roles::cases(), 'value'))],
        ];
    }

    /**
     * @inheritDoc
     * @return CreateUserDTO
     */
    public function asObject(): CreateUserDTO
    {
        return new CreateUserDTO(
            (string)$this->input('name'),
            (string)$this->input('email'),
            (string)$this->input('password'),
            Roles::from((int)$this->input('role', Roles::USER->value)),
        );
    }
}

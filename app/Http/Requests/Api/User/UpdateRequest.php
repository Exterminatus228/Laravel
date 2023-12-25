<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\User;

use App\Http\DTO\Api\User\UpdateUserDTO;
use App\Http\Enums\Permissions;
use App\Http\Enums\Roles;
use App\Http\Requests\Api\ApiRequest;
use App\Models\User;
use Closure;
use Illuminate\Validation\Rule;

/**
 * Class UpdateRequest
 */
class UpdateRequest extends ApiRequest
{
    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return $this->user() instanceof User;
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        /**
         * @var User $user
         */
        $user = $this->user();
        $isSuperAdmin = $this->user()->hasRoles([Roles::SUPER_ADMIN]);
        $canUpdateAdminFields = $isSuperAdmin
            || $user->hasPermissions([Permissions::CAN_UPDATE_USERS]);
        $roles = Roles::cases();
        $validateAdminFields =  static function (string $attribute, mixed $value, Closure $fail) use ($canUpdateAdminFields) {
            if (!$canUpdateAdminFields) {
                $fail("Can not update {$attribute} field. Action is not allowed");
            }
        };

        if (!$isSuperAdmin) {
            $roles = array_filter($roles, static function (Roles $role) {
                return $role !== Roles::SUPER_ADMIN;
            });
        }

        return array_merge(parent::rules(), [
            'id' => ['required', 'numeric', 'exists:users,id', static function (string $attribute, mixed $value, Closure $fail) use ($user) {
                $updateUser = User::query()
                    ->where('id', '=', $value)
                    ->first();

                if (!$updateUser
                    || !$user->can('update', $updateUser)
                ) {
                    $fail("Can not update user with id $value. Action is not allowed");
                }
            },],
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'max:255'],
            'roles' => ['nullable', 'array', $validateAdminFields, Rule::excludeIf(!$canUpdateAdminFields)],
            'roles.*' => ['numeric', $validateAdminFields, Rule::in(array_column($roles, 'value')), Rule::excludeIf(!$canUpdateAdminFields)],
            'is_email_confirmed' => ['nullable', 'boolean', $validateAdminFields, Rule::excludeIf(!$canUpdateAdminFields)],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function asObject(): UpdateUserDTO
    {
        $id = $this->input('id')
            ? (int)$this->input('id')
            : null;
        $name = $this->input('name')
            ? (string)$this->input('name')
            : null;
        $email = $this->input('email')
            ? (string)$this->input('email')
            : null;
        $password = $this->input('password')
            ? (string)$this->input('password')
            : null;
        $isEmailConfirmed = $this->input('is_email_confirmed')
            ? (bool)$this->input('is_email_confirmed')
            : null;
        $roles = (array)$this->input('roles', [Roles::USER]);

        return new UpdateUserDTO(
            $id,
            $name,
            $email,
            $password,
            $roles,
            $isEmailConfirmed
        );
    }
}

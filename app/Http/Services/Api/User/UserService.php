<?php

declare(strict_types=1);

namespace App\Http\Services\Api\User;

use App\Http\DTO\Api\User\CreateUserDTO;
use App\Http\DTO\Api\User\LoginDTO;
use App\Http\Exceptions\Api\ApiException;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class UserService
 */
class UserService implements UserServiceInterface
{
    /**
     * @inheritDoc
     */
    public function createUser(CreateUserDTO $dto): User
    {
        $user = User::query()->updateOrCreate([
            'email' => $dto->getEmail(),
        ], [
            'name' => $dto->getName(),
            'password' => $dto->getPassword(),
        ])->first();

        if (!$user instanceof User) {
            throw new ApiException('User was not saved');
        }

        $role = Role::query()->where('type', '=', $dto->getRole()->value)->first();

        if ($role instanceof Role
            && !$user->hasRoles([$dto->getRole()])
        ) {
            $user->roles()->where('role_id')->attach($role->id);
        }

        $user->tokens()->delete();
        $token = $user->createToken(self::PERSONAL_TOKEN_KEY)->plainTextToken;
        $user->remember_token = $token;

        if (!$user->save()) {
            throw new ApiException('User token was not remembered');
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function login(LoginDTO $dto): string
    {
        try {
            $user = User::query()->where('email', $dto->getEmail())->first();

            if (!$user instanceof User
                || !Hash::check($dto->getPassword(), $user->password)
            ) {
                throw new Exception('Invalid credentials provided');
            }

            $token = PersonalAccessToken::findToken($user->remember_token);

            if (!$token instanceof PersonalAccessToken) {
                throw new Exception('User has not api tokens');

            }

            return $user->remember_token;
        } catch (Throwable $exception) {
            $bug = new MessageBag();
            $bug->add('error', $exception->getMessage());
            $response = response()->json($bug);
            $response->setStatusCode(422);

            throw new HttpResponseException($response);
        }
    }
}

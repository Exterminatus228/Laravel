<?php

declare(strict_types=1);

namespace App\Http\Services\Api\User;

use App\Http\DTO\Api\User\UpdateUserDTO;
use App\Http\DTO\Api\User\UserDTO;
use App\Http\DTO\Api\User\LoginDTO;
use App\Http\Enums\Roles;
use App\Http\Exceptions\Api\ApiException;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Laravel\Sanctum\PersonalAccessToken;
use RuntimeException;
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
    public function create(UserDTO $dto): User
    {
        $user = new User();
        $user->email = $dto->getEmail();
        $user->password = $dto->getPassword();
        $user->name = $dto->getName();
        $user->email_verified_at = $dto->isEmailVerified()
            ? time()
            : null;

        if (!$user->save()) {
            throw new ApiException('User was not saved');
        }

        $this->attachRoles($user, $dto->getRoles());
        $this->createToken($user);

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function login(LoginDTO $dto): User
    {
        try {
            $user = User::query()->where('email', $dto->getEmail())->first();

            if (!$user instanceof User
                || !Hash::check($dto->getPassword(), $user->password)
            ) {
                throw new RuntimeException('Invalid credentials provided');
            }

            $token = PersonalAccessToken::findToken($user->remember_token);

            if (!$token instanceof PersonalAccessToken) {
                $this->createToken($user);
            }

            return $user;
        } catch (Throwable $exception) {
            $bug = new MessageBag();
            $bug->add('error', $exception->getMessage());
            $response = response()->json($bug);
            $response->setStatusCode(422);

            throw new HttpResponseException($response);
        }
    }

    /**
     * @inheritDoc
     */
    public function confirm(int $id): User
    {
        /**
         * @var User $user
         */
        $user = User::query()->where('id', '=', $id)->firstOrFail();
        $user->email_verified_at = time();

        if (!$user->save()) {
            throw new ApiException('User was not confirmed');
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        User::query()->where('id', '=', $id)->delete();
    }

    /**
     * @inheritDoc
     */
    public function update(UpdateUserDTO $dto): User
    {
        /**
         * @var User $user
         */
        $user = User::query()
            ->where('id', '=', $dto->getId())
            ->firstOrFail();

        if ($dto->getName() !== null) {
            $user->name = $dto->getName();
        }

        if ($dto->getPassword() !== null) {
            $user->password = Hash::make($dto->getPassword());
        }

        if ($dto->getEmail() !== null) {
            $user->email = $dto->getEmail();
            $user->email_verified_at = null;
        }

        if ($dto->getPassword() !== null
            || $dto->getEmail() !== null
        ) {
            $user->tokens()->delete();
            $user->remember_token = null;
        }

        if ($dto->isEmailVerified() !== null) {
            $user->email_verified_at = time();
        }

        if (!$user->save()) {
            throw new ApiException('User was not saved');
        }

        if ($dto->isEmailVerified() !== null) {
            $this->createToken($user);
        }

        if ($dto->getRoles() !== null) {
            $this->attachRoles($user, $dto->getRoles());
        }

        return $user;
    }

    /**
     * @param User $user
     * @return void
     * @throws ApiException
     */
    private function createToken(User $user): void
    {
        $user->tokens()->delete();
        $token = $user->createToken(self::PERSONAL_TOKEN_KEY)->plainTextToken;
        $user->remember_token = $token;

        if (!$user->save()) {
            throw new ApiException('User token was not remembered');
        }
    }

    /**
     * @param User $user
     * @param Roles[] $newRoles
     * @return void
     */
    private function attachRoles(User $user, array $newRoles): void
    {
        $user->roles()->detach(array_column($user->roles()->get()->toArray(), 'id'));
        $roles = Role::query()
            ->whereIn('type', array_column($newRoles, 'value'))
            ->get();
        $user->roles()->attach(array_column($roles->toArray(), 'id'));
    }
}

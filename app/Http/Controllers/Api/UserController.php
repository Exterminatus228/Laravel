<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\User\DeleteRequest;
use App\Http\Requests\Api\User\LoginRequest;
use App\Http\Requests\Api\User\SignUpRequest;
use App\Http\Requests\Api\User\UpdateRequest;
use Illuminate\Routing\Controller;
use App\Http\Services\Api\User\UserServiceInterface;
use App\Http\Requests\Api\User\CreateRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Class UserController
 */
class UserController extends Controller
{
    /**
     * @param UserServiceInterface $service
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function confirm(
        int $id,
        UserServiceInterface $service
    ): JsonResponse {
        $user = $service->confirm($id);

        return response()->json([
            'confirmedAt' => $user->email_verified_at,
            'loginLink' => route('login')
        ]);
    }

    /**
     * @param int $id
     * @param DeleteRequest $request
     * @param UserServiceInterface $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function delete(
        int $id,
        DeleteRequest $request,
        UserServiceInterface $service
    ): JsonResponse {
        $service->delete($id);

        return response()->json();
    }

    /**
     * @param UserServiceInterface $service
     * @param SignUpRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function signUp(
        SignUpRequest $request,
        UserServiceInterface $service
    ): JsonResponse {
        $user =  $service->create($request->asObject());

        return response()->json([
            'confirmationLink' => route('user.confirm', ['id' => $user->id])
        ]);
    }

    /**
     * @param UserServiceInterface $service
     * @param CreateRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function create(
        CreateRequest $request,
        UserServiceInterface $service
    ): JsonResponse {
        return response()->json([
            'token' => $service->create($request->asObject())->remember_token,
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param UserServiceInterface $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(
        UpdateRequest $request,
        UserServiceInterface $service
    ): JsonResponse {
        return response()->json([
            'token' => $service->update($request->asObject())->remember_token,
        ]);
    }

    /**
     * @param UserServiceInterface $service
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function login(
        LoginRequest $request,
        UserServiceInterface $service
    ): JsonResponse {
        return response()->json([
            'token' => $service->login($request->asObject())->remember_token,
        ]);
    }
}

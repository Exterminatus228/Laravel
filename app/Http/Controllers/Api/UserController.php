<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\User\LoginRequest;
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
     * @param CreateRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function create(
        CreateRequest $request,
        UserServiceInterface $service
    ): JsonResponse {
        return response()->json([
            'token' => $service->createUser($request->asObject())->remember_token,
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
            'token' => $service->login($request->asObject()),
        ]);
    }
}

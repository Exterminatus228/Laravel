<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserConfirmedMiddleware
 */
class UserConfirmedMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var User $user
         */
        $user = $request->user();

        if (!$user instanceof User) {
            return response([
                'message' => 'Unauthorized.',
            ], 401);
        }

        if ($user->email_verified_at !== null) {
            return $next($request);
        }

        return response([
            'message' => 'Unauthorized. User is not confirmed',
            'confirmationLink' => route('user.confirm', ['id' => $user->id]),
        ], 401);
    }
}

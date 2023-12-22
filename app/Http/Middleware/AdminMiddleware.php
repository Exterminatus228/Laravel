<?php

namespace App\Http\Middleware;

use App\Http\Enums\Roles;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminMiddleware
 */
class AdminMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user instanceof User
            && $user->hasRoles([Roles::ADMIN, Roles::SUPER_ADMIN])
        ) {
            return $next($request);
        }

        return response()->setStatusCode(401);
    }
}

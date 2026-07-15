<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        $staffRoles = ['admin', 'doctor'];
        $isStaffByColumn = in_array($user->role, $staffRoles, true);
        $isStaffBySpatie = method_exists($user, 'hasAnyRole') && $user->hasAnyRole($staffRoles);

        if (! $isStaffByColumn && ! $isStaffBySpatie) {
            abort(403);
        }

        return $next($request);
    }
}

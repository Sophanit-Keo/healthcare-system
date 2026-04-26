<?php

namespace App\Http\Middleware;

use App\Models\Patient;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PatientMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        $isPatientByColumn = ($user->role ?? null) === 'patient';
        $isPatientBySpatie = method_exists($user, 'hasRole') && $user->hasRole('patient');

        if (! $isPatientByColumn && ! $isPatientBySpatie) {
            abort(403);
        }

        if (! $user->relationLoaded('patient') && ! $user->patient) {
            Patient::firstOrCreate(['user_id' => $user->id]);
        }

        return $next($request);
    }
}


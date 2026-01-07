<?php

namespace App\Http\Middleware;

use App\Enums\Peran;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();

        // Convert enum value to string for comparison
        $userRole = $user->peran instanceof Peran ? $user->peran->value : $user->peran;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');

        // This line will never be reached but satisfies static analysis
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessPenjemputanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && in_array($user->role, ['super_admin', 'kepala_dinas', 'end_user'])) {
            return $next($request);
        }
        abort(403, 'Unauthorized action.');
    }
}

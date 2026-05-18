<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || is_null($user->email_verified_at)) {
            return redirect('/')
                ->with('error', 'Akun Anda belum diverifikasi oleh admin.');
        }

        return $next($request);
    }
}

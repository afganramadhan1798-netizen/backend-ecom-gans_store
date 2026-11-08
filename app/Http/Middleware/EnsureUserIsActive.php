<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->is_active) {

            // Hapus token pengguna yang sudah dinonaktifkan
            $user?->currentAccessToken()?->delete();

            return response()->json([
                'success' => false,
                'message' => 'Akun kamu sedang dinonaktifkan.',
            ], 403);
        }

        return $next($request);
    }
}
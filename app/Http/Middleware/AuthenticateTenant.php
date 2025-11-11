<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-Key') ?? $request->bearerToken();

        if ( ! $apiKey) {
            return response()->json([
                'message' => 'API key is vereist',
            ], 401);
        }

        $tenant = Tenant::where('api_key', $apiKey)
            ->where('is_active', true)
            ->first();

        if ( ! $tenant) {
            return response()->json([
                'message' => 'Ongeldige of inactieve API key',
            ], 401);
        }

        $request->setUserResolver(fn () => $tenant);

        return $next($request);
    }
}

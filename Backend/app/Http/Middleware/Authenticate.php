<?php

namespace App\Http\Middleware;

use App\Http\Helpers\ApiResponse;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {

        // if ($request->expectsJson()) {
        //     abort(response()->json(['message' => 'Non authentifié.'], 401));
        // }

        return ApiResponse::return_error_response(ApiResponse::UNAUTHORIZED, 'Veuilillez vous authentifier', 401);

        // return $request->expectsJson() ? null : route('login');
    }
}

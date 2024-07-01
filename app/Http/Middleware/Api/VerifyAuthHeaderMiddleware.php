<?php

namespace App\Http\Middleware\Api;

use Closure;
use App\Services\API\CallbackService;

class VerifyAuthHeaderMiddleware
{
    protected $callbackService;

    public function __construct(CallbackService $callbackService)
    {
        $this->callbackService = $callbackService;
    }

    public function handle($request, Closure $next)
    {
        $verify = $this->callbackService->verifyAuthHeader($request);

        if (!$verify) {
            return response()->json(['status' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}

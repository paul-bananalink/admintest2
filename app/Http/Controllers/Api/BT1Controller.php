<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BT1Controller extends Controller
{
    public function verifyToken()
    {
        if (Auth::guard('sanctum')->check()) {
            return response()->json(['status' => 'success', 'message' => 'Token is valid', 'member' => Auth::guard('sanctum')->user()]);
        }

        return response()->json(['status' => 'error', 'message' => 'Token is invalid']);
    }

    public function refreshToken()
    {
        $expires_at = now()->addMinutes(app('site_info')->siTimeOUt ?? 120);

        $user = Auth::guard('sanctum')->user();
        $user->tokens()->delete();

        $token = $user->createToken(uniqid(), expiresAt: $expires_at)->plainTextToken;

        return response()->json(['status' => 'success', 'message' => 'Token is refreshed', 'token' => $token]);
    }
}

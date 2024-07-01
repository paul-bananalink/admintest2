<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\API\CallbackService;
use Illuminate\Http\Request;

class CallbackAPIController extends Controller
{
    public function __construct(private CallbackService $callbackService)
    {
    }

    public function getBalance(Request $request)
    {
        return $this->callbackService->balance($request->all());
    }

    public function postTransaction(Request $request)
    {
        $data = $this->callbackService->transaction($request->all());

        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\API\IntegrationAPIService;

class IntegrationAPIController extends Controller
{
    public function __construct(private IntegrationAPIService $integrationAPIService)
    {
    }

    public function getBalance()
    {
        return $this->integrationAPIService->getBalance();
    }

    public function getGameProviders()
    {
        return $this->integrationAPIService->gameProviders();
    }

    public function getGames(Request $request)
    {
        return $this->integrationAPIService->games($request->all());
    }

    public function launchGame(Request $request)
    {
        return $this->integrationAPIService->launchGame($request->all());
    }

    public function kickPlayer(Request $request)
    {
        return $this->integrationAPIService->kickPlayer($request->all());
    }
}

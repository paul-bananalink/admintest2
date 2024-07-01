<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\API\DataFeedService;
use Illuminate\Http\Request;

class DataFeedAPIController extends Controller
{
    public function __construct(private DataFeedService $dataFeedService)
    {
    }

    public function getTransaction(Request $request)
    {
        return $this->dataFeedService->getTransaction($request->all());
    }

    public function getTransactions()
    {
        return $this->dataFeedService->getTransactions();
    }

    public function openGameHistory(Request $request)
    {
        return $this->dataFeedService->openGameHistory($request->all());
    }

    public function gameRoundDetailsById(Request $request)
    {
        return $this->dataFeedService->gameRoundDetailsById($request->all());
    }

    public function gameRoundDetails(Request $request)
    {
        return $this->dataFeedService->gameRoundDetails($request->all());
    }

    public function gameHistoryDetails(Request $request)
    {
        return $this->dataFeedService->gameHistoryDetails($request->all());
    }
}

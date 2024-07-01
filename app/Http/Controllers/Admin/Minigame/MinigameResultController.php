<?php

namespace App\Http\Controllers\Admin\Minigame;

use App\Http\Controllers\Controller;
use App\Services\MinigameResultService;

class MinigameResultController extends Controller
{
    public function __construct(private MinigameResultService $minigameResultService)
    {
    }

    public function processGameSurepowerball(string $version)
    {
        $this->minigameResultService->processGameSurepowerball(null, $version);
    }

}

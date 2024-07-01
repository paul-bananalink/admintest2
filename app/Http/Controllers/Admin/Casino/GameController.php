<?php

namespace App\Http\Controllers\Admin\Casino;

use App\Http\Controllers\Controller;
use App\Services\GameService;

class GameController extends Controller
{
    public function __construct(
        private GameService $gameService,
    ) {
    }

    public function handleGame()
    {
        $this->gameService->handleGetGame();
        return 'Update game success!';
    }
}

<?php

namespace App\Console\Commands;

use App\Events\Client\MiniGameEvent;
use App\Services\MinigameResultService;
use Illuminate\Console\Command;

class SurePowerBallMinigameCommand extends Command
{
    private $gameName = 'surepowerball';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minigame:surepowerball {version}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'process data game surepowerball';

    /**
     * Execute the console command.
     */
    public function handle(MinigameResultService $minigameResultService)
    {
        $version = $this->argument('version');

        $minigameResultService->processGameSurepowerball(null, $version);

        // discordSendMessage('SurePowerBall version  ' . $version . ' result updated at: ' . date('Y-m-d H:i:s'));

        $results = $minigameResultService->getGameResults(['mgName' => $this->gameName, 'mgrMode' => $version, 'limit' => 1]);
        event(new MiniGameEvent($this->gameName, $version, $results));
    }
}

<?php

namespace App\Console\Commands;

use App\Events\Client\MiniGameEvent;
use Illuminate\Console\Command;
use App\Repositories\MinigameRepository;
use App\Repositories\MinigameResultRepository;
use App\Services\API\MiniGameAPIService;
use App\Services\MinigameResultService;

class Game365MinigameCommand extends Command
{
    private $gameName = 'game365';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minigame:game365';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description game365';

    public function __construct(
        protected MiniGameAPIService $miniGameAPIService,
        protected MinigameResultService $minigameResultService,
        protected MinigameRepository $minigameRepository,
        protected MinigameResultRepository $minigameResultRepository,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $minigame = $this->minigameRepository->findByName($this->gameName);
        $minigameResult = $this->minigameResultRepository->findLatestByMiniGame($minigame->mgNo);

        $mgNo = $minigame->mgNo;
        $mgrRound = $minigameResult?->mgrRound;

        $data = null;
        $isDataValid = false;
        $retryCount = 0;

        do {
            $data = $this->miniGameAPIService->getGame365();
            $isDataValid = $this->validateData($mgrRound, $data);
            if ($isDataValid) break;
            sleep(0.5);

            if ($retryCount >= config('minigame.max_retry')) {
                // discordSendMessage('GAME365 failed at round ' . $mgrRound + 1);
                return;
            };

            $retryCount++;
        } while (!$isDataValid);

        $formattedData = $this->formatData($data, $mgNo);
        $this->minigameResultRepository->create($formattedData);

        $results = $this->minigameResultService->getGameResults(['mgName' => $this->gameName, 'mgrMode' => null, 'limit' => 1]);
        event(new MiniGameEvent($this->gameName, null, $results));
    }

    private function validateData($mgrRound, $data)
    {
        return $mgrRound != $data['round'];
    }

    private function formatData($data, $mgNo)
    {
        $powerball = (int) $data['drawn']['powerball'];
        $ball = $data['drawn']['normal'];

        return [
            'mgrRound' => $data['round'],
            'mgrMode' => null,
            'mgrResult' => ['ball' => $ball, 'powerball' => $powerball],
            'mgNo' => $mgNo,
        ];
    }
}

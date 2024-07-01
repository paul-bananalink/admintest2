<?php

namespace App\Console\Commands;

use App\Events\Client\MiniGameEvent;
use App\Repositories\MinigameRepository;
use App\Repositories\MinigameResultRepository;
use App\Services\API\MiniGameAPIService;
use App\Services\MinigameResultService;
use Illuminate\Console\Command;

class NtryMiniGameCommand extends Command
{
    private $gameName = 'ntry';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minigame:ntry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $isDataValid = false;
        $data = null;
        $minigame = $this->minigameRepository->findByName($this->gameName);
        $minigameResult = $this->minigameResultRepository->findLatestByMiniGame($minigame->mgNo);
        $mgNo = $minigame->mgNo;
        $mgrRound = $minigameResult?->mgrRound;
        $retryCount = 0;

        do {
            $data = $this->miniGameAPIService->getGameNtry();
            $isDataValid = $this->validateData($mgrRound, $data);

            if ($isDataValid) break;

            if ($retryCount >= config('minigame.max_retry')) {
                // discordSendMessage('Ntry get data failed at round ' . $mgrRound + 1);
                return;
            };

            sleep(0.5);
            $retryCount++;
        } while (!$isDataValid);

        $data = $this->formatData($data, $mgNo);
        $this->minigameResultRepository->create($data);

        $results = $this->minigameResultService->getGameResults(['mgName' => $this->gameName, 'mgrMode' => null, 'limit' => 1]);
        event(new MiniGameEvent($this->gameName, null, $results));
    }

    private function validateData($mgrRound, $data)
    {
        return $mgrRound != $data['date_round'];
    }

    private function formatData($data, $mgNo)
    {
        $powerball = (int) array_pop($data['ball']);
        $ball = $data['ball'];

        return [
            'mgrRound' => $data['date_round'],
            'mgrMode' => null,
            'mgrResult' => ['ball' => $ball, 'powerball' => $powerball],
            'mgNo' => $mgNo,
        ];
    }
}

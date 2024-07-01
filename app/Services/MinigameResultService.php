<?php

namespace App\Services;

use App\Repositories\MinigameRepository;
use App\Repositories\MinigameResultRepository;
use App\Services\API\MiniGameAPIService;

class MinigameResultService extends BaseService
{

    public function __construct(
        private MinigameResultRepository $minigameResultRepository,
        private MinigameRepository $minigameRepository,
        private MiniGameAPIService $miniGameAPIService,
    ) {
    }

    public function getRepo(): MinigameResultRepository
    {
        return $this->minigameResultRepository;
    }

    public function processGameSurepowerball(string $url = null, string $version)
    {
        $dataApi = $this->getApiGameSurepowerball(null, $version);

        $minigameResultData = $this->initDataGameSurepowerball($dataApi, $version);

        $existingMinigameResult = $this->minigameResultRepository->getRecordExist($minigameResultData['mgrRound']);

        $this->minigameResultRepository->updateOrCreate(
            [
                'mgrNo' => $existingMinigameResult?->mgrNo
            ],
            $minigameResultData
        );
    }

    public function getApiGameSurepowerball(string $url = null, string $version, int $retryCount = 0): array
    {
        if (!$url) {
            $url = config('minigame.url.surepowerball') . "?version={$version}";

            try {
                $dataJson = file_get_contents($url);
                $data = json_decode($dataJson, true);
                $data['round'];
                $data['await_seconds'];
            } catch (\Exception $e) {
                ++$retryCount;
                logger("loop v1 $retryCount : $data");
                if ($retryCount < 20) {
                    sleep(0.5);
                    return $this->getApiGameSurepowerball(null, $version, $retryCount + 1);
                } else {
                    logger('data api is null or not exist 1');
                    logger($e->getMessage());
                    return [];
                }
            }

            $url = config('minigame.url.surepowerball') . "?version={$version}" . "&round={$data['round']}";

            // discordSendMessage('SurePowerBall sleep: ' . $data['await_seconds'] . ' seconds');

            if ($data['await_seconds'] > 0) {
                sleep($data['await_seconds']);
            }
            return $this->getApiGameSurepowerball($url, $version);

            logger('data api is null or not exist 2');
            return [];
        }

        try {
            $dataJson = file_get_contents($url);
            $data = json_decode($dataJson, true);
            $data['round'];
            $data['await_seconds'];
            $data['ball'];
        } catch (\Exception $e) {
            ++$retryCount;
            logger("loop v2 $retryCount : $data");
            if ($retryCount < 20) {
                sleep(1);
                return $this->getApiGameSurepowerball($url, $version, $retryCount + 1);
            } else {
                logger('data api is null or not exist 3');
                logger($e->getMessage());
                return false;
            }
        }

        return json_decode($dataJson, true);
    }

    public function initDataGameSurepowerball(array $dataGameSurepowerball, string $version)
    {
        $ball = explode(',', $dataGameSurepowerball['ball']);

        // Extracting the powerball number
        $powerball = array_pop($ball);

        // Constructing the result array
        $mgrResult = [
            'ball' => $ball,
            'powerball' => $powerball,
        ];

        return [
            'mgrRound' => $dataGameSurepowerball['round'],
            'mgrMode' => $version,
            'mgrResult' => $mgrResult,
            'mgNo' => 1,
        ];
    }

    public function getGameResults(array $attributes): array
    {
        $miniGame = $this->minigameRepository->findByName($attributes['mgName']);
        $data = $this->minigameResultRepository->getResults($miniGame->mgNo, $attributes['mgrMode'] ?? null, $attributes['limit'] ?? null);
        foreach ($data as $item) {
            foreach ($item->mgrResult['ball'] as $index => $type) {
                $result['ball_' . $index + 1] = $type;
            }
            $result['powerball'] = $item->mgrResult['powerball'];
            $results[] = [
                'round' => $item->mgrRound,
                'mode' => $item->mgrMode,
                'date' => $item->mgrRegDate->toDateTimeString(),
                ...$result,
            ];
        }

        return $results;
    }
}

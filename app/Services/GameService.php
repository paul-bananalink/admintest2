<?php

namespace App\Services;

use App\Exceptions\GraphQLException;
use App\Repositories\GameRepository;
use App\Services\API\IntegrationAPIService;
use App\Repositories\GameProviderRepository;
use Monolog\Processor\UidProcessor;

class GameService extends BaseService
{
    const COUNTRY_CODE = 'KR';

    const LOCAL_CODE = 'ko';

    const OK_STATUS = 'OK';

    public function __construct(
        private IntegrationAPIService $integrationAPIService,
        private GameRepository $gameRepo,
        private GameProviderRepository $gameProviderRepo
    ) {
    }

    /**
     * Retrieves the game information and launches the game for the authenticated user.
     *
     * @param array $attributes The attributes required to launch the game.
     * @return Game The game object with the launch game URL.
     * @throws GraphQLException If there is an error launching the game.
     */
    public function getGameUrl($attributes)
    {
        $guard = config('constant_view.GUARD.SANCTUM');
        $member = auth()->guard($guard)->user();

        $attributes['playerCode'] = $member->mID;
        $attributes['nickname'] = $member->mNick;
        $attributes['countryCode'] = $attributes['countryCode'] ?? self::COUNTRY_CODE;
        $attributes['LocaleCode'] = $attributes['LocaleCode'] ?? self::LOCAL_CODE;
        $attributes['isIframe'] = true;

        $response = $this->integrationAPIService->launchGame($attributes);

        if ($response['status'] == self::OK_STATUS) {
            return $response['result']['gameUrl'];
        } else {
            $error = $response['title'] ?? config('hera_game.errors.seamless_wallet')[$response['status']];
            throw new GraphQLException($error);
        }
    }

    public function handleGetGame()
    {
        $categories = [
            'Slot',
            'Live Casino',
            'Other'
        ];

        $providers = $this->gameProviderRepo->getListWithConditions();

        $attributes = [];
        foreach ($categories as $category) {
            foreach ($providers as $provider) {
                $attributes[] = [
                    'providerCode' => $provider->gpCode,
                    'category' => $category
                ];
            }
        }

        $this->syncGame($attributes);
    }

    public function toggleField(string $field, int $gNo): bool
    {
        $config = $this->gameRepo->getConfig($gNo);

        if (empty($config)) {
            return false;
        }

        $data = [];
        $data[$field] = data_get($config, $field) ? 0 : 1;

        return $this->tryCatchFuncDB(function () use ($gNo, $data) {
            $this->gameRepo->updateByPK($gNo, $data);
        });
    }

    public function updateGame(array $attributes): bool
    {
        return $this->tryCatchFuncDB(function () use ($attributes) {
            foreach ($attributes as $key => $value) {
                $this->gameRepo->updateByPK($key, $value);
            }
        });
    }

    private function syncGame(array $attributes)
    {
        foreach ($attributes as $attribute) {
            $this->createGame(
                $this->integrationAPIService->games($attribute),
                $attribute['providerCode']
            );
        }
    }

    private function createGame(array $data, $providerCode)
    {
        if ($data['status'] === 'OK') {
            $data = $data['result'];

            foreach ($data as $item) {
                $attr = [
                    'gCode' => data_get($item, 'code'),
                    'gpCode' => $providerCode,
                    'gName' => data_get($item, 'name'),
                    'gNameEn' => data_get($item, 'name_en'),
                    'gCategory' => data_get($item, 'category'),
                    'gIconUrl' => data_get($item, 'iconUrl')
                ];

                $this->gameRepo->existsAndCreate(['where' => [['gCode', $attr['gCode']]]], $attr);
            }
        }
    }
}

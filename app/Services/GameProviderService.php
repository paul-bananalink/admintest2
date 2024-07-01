<?php

namespace App\Services;

use App\Models\GameProvider;
use App\Services\API\IntegrationAPIService;
use App\Repositories\GameProviderRepository;
use App\Repositories\GameRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class GameProviderService extends BaseService
{
    public function __construct(
        private IntegrationAPIService $integrationAPIService,
        private GameProviderRepository $gameProviderRepository,
        private GameRepository $gRepo,
        private MemberConfigService $memberConfigService
    ) {
    }

    public function getGamesByGpCode(string $gpCode = '')
    {
        if (empty($gpCode)) {
            return [];
        }

        return $this->gRepo
            ->getGamesByGpCode($gpCode)
            ->chunk(3)
            ->toArray();
    }

    public function getGpCodesCasino()
    {
        return $this->gameProviderRepository->getGpCodesCasino();
    }

    public function changeEnableGameProvider(int $gpNo = null): bool
    {
        if (empty($gpNo)) {
            return false;
        }

        $g_pro = $this->gameProviderRepository->getByPK($gpNo);
        if (empty($g_pro)) {
            return false;
        }

        return $this->tryCatchFuncDB(function () use ($g_pro) {
            $this->gameProviderRepository->updateByPK($g_pro, [
                'gpIsGameProvider' => !data_get($g_pro, 'gpIsGameProvider', true),
            ]);
        });
    }

    public function toggleMaintenanceGameProvider(int $gpNo = null, string $type): bool
    {
        if (empty($gpNo)) return false;

        $g_pro = $this->gameProviderRepository->getByPK($gpNo);

        if (empty($g_pro)) return false;

        $data['gpMaintenance'] = $this->handleDataIsMaintenance($g_pro, $type);

        return $this->tryCatchFuncDB(function () use ($g_pro, $data) {
            $this->gameProviderRepository->updateByPK($g_pro, $data);
        });
    }

    public function changeStatusGame(int $gNo = null): bool
    {
        if (empty($gNo)) {
            return false;
        }

        $game = $this->gRepo->getByPK($gNo);
        if (empty($game)) {
            return false;
        }

        return $this->tryCatchFuncDB(function () use ($game) {
            $this->gRepo->updateByPK($game, [
                'gStatus' => !data_get($game, 'gStatus', true),
            ]);
        });
    }

    public function handle(string $category = '', array $attributes = [])
    {
        if (empty($category)) {
            return [];
        }

        $site = app('site_info');

        $categories = $this->gameProviderRepository->getCategories($category);
        $game_pros = $this->gameProviderRepository->getAllByCategories($categories);
        $game_pros = $this->arrayToPagination($game_pros->toArray(), request('gpPage', 1), 'gpPage');
        if (empty(request('gpCode'))) {
            return [
                'game_pros' => $game_pros,
                'site' => $site,
                'start_no' => $this->getNoTotal($game_pros->total(), $game_pros->perPage(), request('gpPage', 1)),
            ];
        }

        $gp_codes = ($v = request('gpCode')) ? [$v] : $game_pros->pluck('gpCode')->toArray();
        $games = $this->gRepo->getPaginate(conditions: [$this->gameProviderRepository::OPERATOR_WHERE_IN => ['gpCode', $gp_codes]]);
        $start_no = $this->getNoTotal($games->total(), $games->perPage(), request('page', 1));

        $game_pros = $game_pros->keyBy('gpCode');
        return [
            'games' => $games,
            'site' => $site,
            'start_no' => $start_no,
            'game_pros' => $game_pros,
        ];
    }

    public function getGameProvider($attributes)
    {
        $member = auth('sanctum')->user();
        $banned_games = $member->mBanGames ?? [];

        $conditions = [
            'where' => [
                ['gStatus', 1]
            ],
            'whereNotIn' => [
                ['gCode', $banned_games]
            ]
        ];

        if (!empty($attributes['search'])) {
            $search = $attributes['search'];
            $conditions['where'][] = [
                'gName', 'like', '%' . $search . '%'
            ];
            $conditions['orWhere'][] = [
                'gNameEn', 'like', '%' . $search . '%'
            ];
        }

        if (!empty($attributes['gpCode'])) {
            $conditions['where'][] = ['gpCode', $attributes['gpCode']];
        }

        if ($attributes['category'] == \App\Models\GameProvider::NAME_CASINO) {
            $gpCodes = $this->gameProviderRepository->getGpCodesCasino()->pluck('gpCode')->toArray();
        } else {
            $gpCodes = $this->gameProviderRepository->getGpCodesSlot()->pluck('gpCode')->toArray();
        }

        $conditions['whereIn'][] = ['gpCode', $gpCodes];
        $games = $this->gRepo->paginateWithConditions($attributes['offset'], $attributes['limit'], [['gPoint', 'DESC']], $conditions);

        return $games;
    }

    public function getGameProviders($attributes)
    {
        $page = $attributes['offset'];
        $limit = $attributes['limit'];

        $conditions = $this->gameProviderConditions($attributes);

        if (empty($conditions)) {
            return new LengthAwarePaginator([], 0, $limit, $page);
        }

        return $this->gameProviderRepository->paginateWithConditions($page, $limit, [], $conditions);
    }

    public function handleGetGameProvider()
    {
        $providers = $this->integrationAPIService->gameProviders();
        if ($providers['status'] === 'OK') {
            $providers = $providers['result'];
            foreach ($providers as $provider) {
                $attr = [
                    'gpCode' => data_get($provider, 'code'),
                    'gpName' => data_get($provider, 'name'),
                    'gpNameEn' => data_get($provider, 'name_en'),
                    'gpCategory' => data_get($provider, 'category')
                ];

                $this->gameProviderRepository->existsAndCreate(['where' => [['gpCode', $attr['gpCode']]]], $attr);
            }
        }
    }

    private function parseStringToArray($string)
    {
        $array_formatted = [];

        if (!empty($string)) {
            $array = explode(",", $string);
            $array_formatted = array_map('trim', $array);
        }

        return $array_formatted;
    }

    public function getAll()
    {
        $per_page = request('per_page', self::COUNT_PER_PAGE);
        return $this->gameProviderRepository->getPaginate($per_page, [], [], ['gpNo', 'desc']);
    }

    public function update(int $id, array $attributes)
    {
        $data = $this->gameProviderRepository->getByPK($id);

        if (!$data) return false;

        $attributes['gpAvatar'] = $attributes['image_upload'];

        return $this->tryCatchFuncDB(fn () => $this->gameProviderRepository->updateByPK($id, $attributes));
    }

    private function gameProviderConditions($attributes)
    {
        $site = app('site_info');

        $member = auth('sanctum')->user();

        $categories = $attributes['categories'] ? $this->parseStringToArray($attributes['categories']) : ['Slot', 'Live Casino', 'Slot + Live Casino'];

        $categories = $this->whereCategories($categories, $site, $member);

        // Member config
        $listGameNotShow = $this->memberConfigService->listGameProviderIsNotDisplayed($member->mID, $categories);

        if (empty($categories)) {
            return [];
        }

        $whereIn[] = ['gpCategory', $categories];

        $whereNotIn[] = ['gpCode', $member->mBanProviders ?? []];

        // Member config
        $whereNotIn[] = ['gpCode', $listGameNotShow];

        $where[] = ['gpIsGameProvider', 1];

        if (!empty($attributes['search'])) {
            $where[] = ['gpName', 'LIKE', '%' . $attributes['search'] . '%'];
        }

        if (!empty($attributes['game_providers'])) {
            $providers = $this->parseStringToArray($attributes['game_providers']);
            $whereIn[] = ['gpCode', $providers];
        }

        return ['where' => $where, 'whereIn' => $whereIn, 'whereNotIn' => $whereNotIn];
    }

    private function whereCategories($categories, $site, $member)
    {
        $is_member_open_casino = $member->memberConfig->mcCasino ?? true;
        $is_member_open_slot = $member->memberConfig->mcSlot ?? true;

        $is_open_casino = (bool)$site->siIsGameProviderCasino && $is_member_open_casino;
        $is_open_slot = (bool)$site->siIsGameProviderSlot && $is_member_open_slot;

        $casino_categories = \App\Models\GameProvider::CATEGORY_CASINO;

        $slot_categories = \App\Models\GameProvider::CATEGORY_SLOT;

        if (!$is_open_casino) {
            $categories = array_diff($categories, $casino_categories);
        }

        if (!$is_open_slot) {
            $categories = array_diff($categories, $slot_categories);
        }

        return $categories;
    }

    public function handleConfigCasinoByCategory(string $category = '', array $attributes = [])
    {
        if (empty($category)) {
            return [];
        }

        $site = app('site_info');

        $categories = $this->gameProviderRepository->getCategories($category);
        $game_pros = $this->gameProviderRepository->getAllByCategories($categories);

        $gp_codes = ($v = request('gpCode')) ? [$v] : $game_pros->pluck('gpCode')->toArray();
        $game_pro = $this->gameProviderRepository->findByGpCode(request('gpCode'));

        $range_time = !empty($game_pro->gpMaintenance[$category]) ? $game_pro->gpMaintenance[$category]['time'] : null;
        $game_pro->maintain_time = convertStringToDateTimeRange($range_time);

        $conditions = [
            'where' => [
                [function ($query) {
                    $query->where('gName', 'like', '%' . request('search') . '%')
                        ->orWhere('gNameEn', 'like', '%' . request('search') . '%');
                }]
            ],
            'whereIn' => [
                ['gpCode', $gp_codes],
                ['gCategory', $categories]
            ],
        ];
        $games = $this->gRepo->paginate($conditions,  [['gPoint', 'DESC']]);
        $start_no = $this->getNoTotal($games->total(), $games->perPage(), request('page', 1));
        $game_count = $games->total();

        return [
            'games' => $games,
            'site' => $site,
            'start_no' => $start_no,
            'game_pros' => $game_pros,
            'game_pro' => $game_pro,
            'game_count' => $game_count,
        ];
    }

    private function handleDataIsMaintenance(GameProvider $g_pro, string $type)
    {
        // red: on : true - blue: off : false

        $slot_enable = !empty($g_pro->gpMaintenance['slot']) ? $g_pro->gpMaintenance['slot']['enable'] : false;
        $casino_enable = !empty($g_pro->gpMaintenance['casino']) ? $g_pro->gpMaintenance['casino']['enable'] : false;

        if ($type === 'slot') {
            $slot_enable = !$slot_enable;
        }

        if ($type === 'casino') {
            $casino_enable = !$casino_enable;
        }

        $data_slot = [
            'slot' => [
                'enable' => $slot_enable,
                'time' => $g_pro->gpMaintenance[$type]['time'] ?? ''
            ],
        ];

        $data_casino = [
            'casino' => [
                'enable' => $casino_enable,
                'time' => $g_pro->gpMaintenance[$type]['time'] ?? ''
            ],
        ];

        return $this->handleDataMaintenance($g_pro->gpCategory, $type, $data_slot, $data_casino);
    }

    private function handleDataTimeMaintenance(GameProvider $g_pro, string $type, string $time)
    {
        $slot_enable = !empty($g_pro->gpMaintenance['slot']) ? $g_pro->gpMaintenance['slot']['enable'] : false;
        $casino_enable = !empty($g_pro->gpMaintenance['casino']) ? $g_pro->gpMaintenance['casino']['enable'] : false;

        $time_slot_schedule = !empty($g_pro->gpMaintenance['slot']) ? $g_pro->gpMaintenance['slot']['time'] : '';
        $time_casino_schedule = !empty($g_pro->gpMaintenance['casino']) ? $g_pro->gpMaintenance['casino']['time'] : '';

        $data_slot = [
            'slot' => [
                'enable' => $slot_enable,
                'time' => $type === 'slot' ? $time : $time_slot_schedule
            ],
        ];

        $data_casino = [
            'casino' => [
                'enable' => $casino_enable,
                'time' => $type === 'casino' ? $time : $time_casino_schedule
            ],
        ];

        return $this->handleDataMaintenance($g_pro->gpCategory, $type, $data_slot, $data_casino);
    }

    private function handleDataMaintenance(string $gpCategory, string $type, array $data_slot, array $data_casino)
    {
        if ($gpCategory === \App\Models\GameProvider::TYPE_SLOT) {
            return $data_slot;
        } elseif ($gpCategory === \App\Models\GameProvider::TYPE_CASINO) {
            return $data_casino;
        } elseif ($gpCategory === \App\Models\GameProvider::TYPE_SLOT_AND_CASINO) {
            if ($type === 'slot') {
                return array_merge($data_slot, $data_casino);
            } elseif ($type === 'casino') {
                return array_merge($data_slot, $data_casino);
            }
        } else {
            return null;
        }
    }

    public function updateData(string $type, array $attributes)
    {
        $gpNo = $attributes['gpNo'];
        $gp = $this->gameProviderRepository->getByPK($gpNo);

        if (empty($gp)) {
            return false;
        }

        $data = $attributes;

        $data['gpMaintenance'] = $this->handleDataTimeMaintenance($gp, $type, $attributes['gpTimeMaintain']);

        $data = $this->handleDataImages($type, $data, $gp);

        return $this->tryCatchFuncDB(function () use ($gp, $data) {
            $this->gameProviderRepository->updateByPK($gp, $data);
        });
    }

    public function getGameProviderByCategory(string $category = '')
    {
        if (empty($category)) {
            return [];
        }

        $categories = $this->gameProviderRepository->getCategories($category);

        return $this->gameProviderRepository->getAllByCategories($categories)
            ->chunk(4)
            ->toArray();
    }

    private function handleDataImages(string $type, array $data, GameProvider $gp): array
    {
        $data['gpImages'] = [];
        $gpImages = data_get($gp, 'gpImages', []);

        $gpImages[$type] = [
            'logo' => data_get($data, 'gpLogo'),
            'background' => data_get($data, 'gpImgBackground'),
            'avatar' => data_get($data, 'gpAvatar'),
        ];

        $gp->gpImages = $gpImages;

        $data['gpImages'] = $gp->gpImages;

        return $data;
    }
}

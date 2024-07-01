<?php

namespace App\Services;

use App\Events\BaseEvent;
use App\Repositories\GameProviderRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BaseService
{
    const COUNT_PER_PAGE = 30;

    public function __construct()
    {
    }

    /**
     * Array convert to paginator
     *
     * @param $data
     * @int 
     */
    function arrayToPagination(array $data = [], int $current_page = 1, string $page_name = 'page', int $per_page = self::COUNT_PER_PAGE)
    {
        return new LengthAwarePaginator(
            array_slice($data, ($current_page - 1) * $per_page, $per_page),
            count($data),
            $per_page,
            $current_page,
            [
                'path' => url()->current(),
                'pageName' => $page_name,
            ]
        );
    }

    /**
     * Handle try catch for function use DB
     *
     * @param  mixed  $func  this function
     */
    public function tryCatchFuncDB(callable $func): bool
    {
        try {
            DB::beginTransaction();
            $func();
            DB::commit();

            return true;
        } catch (\Throwable $th) {
            discordSendMessage($th->getMessage());
            Log::channel('single')->error($th->getMessage());
            DB::rollBack();
            return false;
        }
    }

    /**
     * Handle try catch for function use DB
     */
    public function tryCatchDB(callable $func): mixed
    {
        try {
            DB::beginTransaction();
            $result = $func();
            DB::commit();

            return $result;
        } catch (\Throwable $th) {
            Log::channel('single')->error($th->getMessage());
            DB::rollBack();

            return false;
        }
    }

    /**
     * Handle calculate total page block ip
     *
     * @param  int  $count_item  total item in array
     */
    protected function totalPage(int $count_item = 0): int
    {
        return ($count_item / self::COUNT_PER_PAGE) + ($count_item % self::COUNT_PER_PAGE != 0 ? 1 : 0);
    }

    /**
     * Run Event on service class
     *
     * @param BaseEvent $event
     * @return void
     */
    public function runEvent(BaseEvent $event): void
    {
        event($event);
    }

    /**
     * Calculates the starting number for a paginated result based on the total number of items, items per page, and current page.
     *
     * @param int $total The total number of items.
     * @param int $perpage The number of items per page.
     * @param int $current_page The current page number.
     * @return int The starting number for the paginated result.
     */
    public function getNoTotal($total, $perpage, $current_page)
    {
        $start_no = $total - ($perpage * ($current_page - 1));
        return $start_no;
    }

    /**
     * Init config
     *
     * @return mixed
     */
    public function initConfig()
    {
        $gameProRepo = new GameProviderRepository();
        $config['status'] = \App\Models\Member::STATUS_MEMBER_TO_STRING;
        $config['levels'] = range(1, 20);
        $config['banks'] = config('constant_view.BANKS');
        $config['casino_providers'] = $gameProRepo->getListWithConditions(['whereIn' => [['gpCategory', \App\Models\GameProvider::CATEGORY_CASINO]]]);
        $config['slot_providers'] = $gameProRepo->getListWithConditions(['whereIn' => [['gpCategory', \App\Models\GameProvider::CATEGORY_SLOT]]]);

        return $config;
    }

    public function responseData(array $data = [], int $status = 200, array $headers = [], $options = 0)
    {
        return response()->json($data, $status, $headers, $options);
    }

    public function convertFloatInArray(array $data): array
    {
        return array_map(function ($value) {
            $value = str_replace(',', '', $value);
            return floatval($value);
        }, $data);
    }

    public function convertStringToFloat(string $value): float
    {
        $value = str_replace(',', '', $value);
        return floatval($value);
    }
}

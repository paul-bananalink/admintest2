<?php

namespace App\Services;

use App\Repositories\MoneyInfoRepository;
use Illuminate\Support\Facades\DB;

class BonusService extends BaseService
{
    public function __construct(
        private MoneyInfoRepository $moneyInfoRepository,
    ) {
    }

     /**
     * Get list bonus to show for page bonus
     *
     * @param array $attributes from request
     * @return array
     */
    public function getBonus($attributes = []): array
    {
        //convert to field
        $order_by = $this->convertToFieldDB(data_get($attributes, 'orderBy', 'm_process_date'));
        //get sort field
        $sort = data_get($attributes, 'sort', config('constant_view.QUERY_DATABASE.DESC')) == config('constant_view.QUERY_DATABASE.DESC');

        //get count load to view
        $total = $this->initTotal($attributes, $order_by);

        if (data_get($attributes, 'filter') == 'sports_first_time_bonus') // click button 스포츠첫충
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'data' => $data,
            ] = $this->getSportsFirstTimeBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'sports_next_time_bonus') // click button 스포츠매충
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'data' => $data,
            ] = $this->getSportsNextTimeBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'casino_first_time_bonus') // click button 카지노첫충
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'data' => $data,
            ] = $this->getCasinoFirstTimeBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'casino_next_time_bonus') // click button 카지노매충
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'data' => $data,
            ] = $this->getCasinoNextTimeBonus($attributes, $order_by, $sort);
        } elseif (data_get($attributes, 'filter') == 'btn_submit') // click button search
        {
            //keyword destructuring assignment or destructuring syntax
            [
                'data' => $data,
            ] = $this->handleQuerySearch($attributes, $order_by, $sort);
        } else // First loading list bonus
        {
            [
                'data' => $data,
            ] = $this->getBonusAll($attributes, $order_by, $sort);
        }

        return compact(
            'data',
            'total',
        );
    }
    
    /**
     * get Bonus all
     *
     * @param array $attributes conditions
     * @param mixed|string $order_by
     * @param bool $sort
     * @return array
     */
    private function getBonusAll(array $attributes = [], mixed $order_by = '', bool $sort = true): array
    {
        $data = $this->moneyInfoRepository->getBonusByAdminFilter(
            null,
            false,
            [
                'order_by' => $order_by,
                'sort' => $sort
            ],
            [
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            request('per_page', 30)
        );
        return [
            'data' => $data,
        ];
    }

    /**
     * getSportsFirstTimeBonus
     *
     * @param array $attributes conditions
     * @param mixed $order_by
     * @param bool $sort
     * @return array
     */
    private function getSportsFirstTimeBonus(array $attributes = [], mixed $order_by = '', bool $sort = true): array
    {
        $data = $this->moneyInfoRepository->getBonusByAdminFilter(
            'sports',
            true,
            [
                'order_by' => $order_by,
                'sort' => $sort
            ],
            [
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            request('per_page', 30)
        );
        return [
            'data' => $data,
        ];
    }

    /**
     * getSportsNextTimeBonus
     *
     * @param array $attributes conditions
     * @param mixed $order_by
     * @param bool $sort
     * @return array
     */
    private function getSportsNextTimeBonus(array $attributes = [], mixed $order_by = '', bool $sort = true): array
    {
        $data = $this->moneyInfoRepository->getBonusByAdminFilter(
            'sports',
            false,
            [
                'order_by' => $order_by,
                'sort' => $sort
            ],
            [
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            request('per_page', 30)
        );
        return [
            'data' => $data,
        ];
    }

    /**
     * getCasinoFirstTimeBonus
     *
     * @param array $attributes conditions
     * @param mixed $order_by
     * @param bool $sort
     * @return array
     */
    private function getCasinoFirstTimeBonus(array $attributes = [], mixed $order_by = '', bool $sort = true): array
    {
        $data = $this->moneyInfoRepository->getBonusByAdminFilter(
            'casino_slot',
            true,
            [
                'order_by' => $order_by,
                'sort' => $sort
            ],
            [
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            request('per_page', 30)
        );
        return [
            'data' => $data,
        ];
    }

    /**
     * getCasinoNextTimeBonus
     *
     * @param array $attributes conditions
     * @param mixed $order_by
     * @param bool $sort
     * @return array
     */
    private function getCasinoNextTimeBonus(array $attributes = [], mixed $order_by = '', bool $sort = true): array
    {
        $data = $this->moneyInfoRepository->getBonusByAdminFilter(
            'casino_slot',
            false,
            [
                'order_by' => $order_by,
                'sort' => $sort
            ],
            [
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            request('per_page', 30)
        );
        return [
            'data' => $data,
        ];
    }

     /**
     * Handle query search when has key search
     *
     * @param array $attributes conditions
     * @param mixed|string $order_by,
     * @param bool $sort = false (asc)
     * @return array
     */
    private function handleQuerySearch(
        array $attributes = [],
        mixed $order_by = 'mProcessDate',
        bool $sort = false
    ): array {
        $data = $this->moneyInfoRepository->getBonusByAdminFilter(
            null,
            false,
            [
                'order_by' => $order_by,
                'sort' => $sort
            ],
            [
                'keyword' => data_get($attributes, 'search', null),
                'start_date' => data_get($attributes, 'start_date', null),
                'end_date' => data_get($attributes, 'end_date', null),
            ],
            request('per_page', self::COUNT_PER_PAGE)
        );
        return [
            'data' => $data,
        ];
    }

    /**
     * ----------------------------------PRIVATE FUNCTION----------------------------------
     */

    private function initTotal($attributes = [], mixed $order_by = ''): array
    {
        [
            'data' => $data,
        ] = $this->getBonusAll($attributes, $order_by);
        $total['total_bonus_all'] = $data->total();

        [
            'data' => $data,
        ] = $this->getSportsFirstTimeBonus($attributes, $order_by);
        $total['total_sports_first_time_bonus'] = $data->total();

        [
            'data' => $data,
        ] = $this->getSportsNextTimeBonus($attributes, $order_by);
        $total['total_sports_next_time_bonus'] = $data->total();

        [
            'data' => $data,
        ] = $this->getCasinoFirstTimeBonus($attributes, $order_by);
        $total['total_casino_first_time_bonus'] = $data->total();

        [
            'data' => $data,
        ] = $this->getCasinoNextTimeBonus($attributes, $order_by);
        $total['total_casino_next_time_bonus'] = $data->total();

        return $total;
    }

    /**
     * Field name on html convert to field on DB
     *
     * @param string|mixed $key
     * @return string|mixed
     */
    private function convertToFieldDB(string $key = 'm_process_date')
    {
        if ($key == config('constant_view.VIEW.SELECT_ALL_FIELD')) {
            return $key;
        }

        if ($key == 'm_id') return 'mID';
        elseif ($key == 'm_partner') return 'partners.pName';
        elseif ($key == 'm_level') return 'member.mLevel';
        elseif ($key == 'm_total_money') return DB::raw("(SELECT COALESCE(SUM(mMoney), 0) + COALESCE(SUM(mSportsMoney), 0) FROM member WHERE member.mID = money_info.mID)");
        elseif ($key == 'mi_type_UD_AD') return DB::raw("(SELECT COALESCE(SUM(miBankMoney), 0) FROM money_info WHERE miStatus = 9 AND miType IN ('UD', 'AD') AND member.mID = money_info.mID)");
        elseif ($key == 'mi_type_UW_AW') return DB::raw("(SELECT COALESCE(SUM(miBankMoney), 0) FROM money_info WHERE miStatus = 9 AND miType IN ('UW', 'AW') AND member.mID = money_info.mID)");
        elseif ($key == 'm_revenue') return DB::raw("(SELECT COALESCE(SUM(miBankMoney), 0) FROM money_info WHERE miStatus = 9 AND miType IN ('UD', 'AD') AND member.mID = money_info.mID) - (SELECT ABS(COALESCE(SUM(miBankMoney), 0)) FROM money_info WHERE miStatus = 9 AND miType IN ('UW', 'AW') AND member.mID = money_info.mID)");
        elseif ($key == 'mi_bonus_money') return 'bonusMoney';
        elseif ($key == 'm_process_date') return 'mProcessDate';

        return 'mID';
    }
}

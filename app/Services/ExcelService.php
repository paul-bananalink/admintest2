<?php

namespace App\Services;

use App\Repositories\MemberRepository;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Facades\Excel;

class ExcelService extends BaseService
{
    /**
     * @param var $export
     */
    private $export;

    public function __construct()
    {
        /**
         * Fake class to export
         */
        $this->export = new class implements FromCollection, Arrayable, ShouldAutoSize
        {
            private array $data;

            public function __construct()
            {
                $this->data = [];
            }

            public function collection()
            {
                return collect($this->data);
            }

            public function toArray(): array
            {
                return $this->data;
            }

            public function setData($data): void
            {
                $this->data = $data;
            }
        };
    }

    function exportExcel(array $data, string $file_name = 'excel.xlsx')
    {
        $this->export->setData($data);
        return Excel::download($this->export, $file_name, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function handleDataForExportMember(array $data = [], bool $check_pw = false, string $file_name = 'excel.xlsx')
    {
        $option_member = data_get($data, 'option_member', []);

        if ($check_pw) {
            if (!Hash::check(data_get($data, 'modal_pw_export', ''), data_get(auth()->user(), 'mPW', ''))) {
                die('비밀번호가 일치하지 않습니다!<br/><a href="javascript:history.back()" class="btn">Go Back</a>');
            }
        }

        if (empty($data)) die('파일 데이터로 출력할 데이터가 없습니다!<br/><a href="javascript:history.back()" class="btn">Go Back</a>');

        $memRepo = new MemberRepository();
        $conditions = [
            'whereNotIn' => [['mLevel', \App\Models\Member::M_LEVEL_TO_LOGIN_ADMIN_PAGE]],
            'orderBy' => [['mRegDate', 'DESC']]
        ];
        $value_condition = data_get($data, 'type_member', 'all_member');

        if ($value_condition == 'all_member') {
            //do nothing
        } elseif ($value_condition == 'member_logged_5days_ago') {
            // Logged date must less than or equal to 5 days
            $conditions['whereDate'] = [['mLoginDateTime', '<=', now()->subDays(5)->format('Y-m-d 23:59:59')]];
            // Form 5 days off to 7 days off
            $conditions['whereBetween'] = [['mLoginDateTime', [now()->subDay(5)->format('Y-m-d 23:59:59'), now()->subDay(7)->format('Y-m-d 00:00:00')]]];
        } elseif ($value_condition == 'member_normal') {
            $conditions['where'] = [['mStatus', \App\Models\Member::M_STATUS_NINE]];
        } elseif ($value_condition == 'member_stop') {
            $conditions['where'] = [['mStatus', \App\Models\Member::M_STATUS_EIGHT]];
        } elseif ($value_condition == 'member_reject_register') {
            //do nothing
        } elseif ($value_condition == 'member_logged_10days_ago') {
            // Logged date must less than or equal to 10 days
            $conditions['whereDate'] = [['mLoginDateTime', '<=', now()->subDays(10)->format('Y-m-d 23:59:59')]];
        } elseif ($value_condition == 'member_recharge') {
            $conditions['whereHas'] = [[
                'money_infos',
                fn ($q) => $q->whereIn('miType', \App\Models\MoneyInfo::MI_TYPE_FILTER['recharge'])
                    ->where('miStatus', \App\Models\MoneyInfo::MI_STATUS_FILTER['approved'])
            ]];
        }
        if (!empty($option_member)) {
            $option_member[] = 'mStatus';
        }
        if (in_array('mRegDate_mApproveRegDate', $option_member)) {
            $option_member[] = 'mRegDate';
            $option_member[] = 'mApproveRegDate';
            $option_member = array_diff($option_member, ['mRegDate_mApproveRegDate']);
        }
        $mems = $memRepo->getListWithConditions($conditions);
        $mems = $mems->map(
            fn ($mem) => array_map(
                function ($field) use ($mem) {
                    if ($field == 'partner_parent') {
                        return data_get($mem, "{$field}.mID");
                    } elseif ($field == 'miType_UD_AD') {
                        return data_get($mem, 'sum_deposit', 0) . '(' . data_get($mem, 'count_deposit', 0) . ')';
                    } elseif ($field == 'miType_UW_AW') {
                        return data_get($mem, 'sum_withdraw', 0) . '(' . data_get($mem, 'count_withdraw', 0) . ')';
                    } elseif ($field == 'win_ratio') {
                        $winning_rate = $mem->transactions()->selectRaw('CASE WHEN SUM(case when tType = "Bet" then tAmount else 0 end) > 0 THEN ROUND(((SUM(case when tType = "Bet" then tAmount else 0 end) - SUM(case when tType = "Win" then tAmount else 0 end)) / SUM(case when tType = "Bet" then tAmount else 0 end)) * 100, 2) ELSE 0 END as winningRate')->first('winningRate');
                        return data_get($winning_rate, 'winningRate', 0.00);
                    } elseif ($field == 'mStatus') {
                        return data_get($mem, 'status_text');
                    } elseif ($field == 'mRegDate') {
                        return data_get($mem, 'mRegDate');
                    } elseif ($field == 'mApproveRegDate') {
                        return data_get($mem, 'mApproveRegDate');
                    } elseif ($field == 'mStatus') {
                        return data_get($mem, 'mStatus');
                    } elseif ($field == 'mPhone') {
                        if (data_get($mem, 'mPhoneCom')) {
                            $maskedPhone = $mem->mPhoneCom
                                ? preg_replace('/(\d{4})$/', '****', $mem->mPhone)
                                : $mem->mPhone;
                            return $maskedPhone;
                        } else {
                            return data_get($mem, 'mPhone');
                        }
                    } else {
                        return data_get($mem, $field);
                    }
                },
                $option_member
            )
        );

        if ($mems->isNotEmpty()) {
            $columns = array_map(fn ($key) => config("constant_view.MODAL_EXPORT_EXCEL.OPTION_MEMBER.{$key}"), $option_member);

            $this->export->setData([[$columns], $mems->toArray()]);
            return Excel::download($this->export, $file_name, \Maatwebsite\Excel\Excel::XLSX);
        }

        $this->export->setData([['no record']]);
        return Excel::download($this->export, $file_name, \Maatwebsite\Excel\Excel::XLSX);
    }
}

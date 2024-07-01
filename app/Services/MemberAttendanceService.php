<?php

namespace App\Services;

use App\Repositories\MemberAttendanceRepository;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\GraphQLException;
use App\Models\BonusConfig;
use App\Models\MoneyInfo;
use App\Models\Member;
use App\Repositories\BonusConfigRepository;
use App\Repositories\MoneyInfoRepository;
use Carbon\Carbon;

class MemberAttendanceService extends BaseService
{
    public function __construct(
        private MemberAttendanceRepository $memberAttendanceRepository,
        private BonusConfigRepository $bonusConfigRepository,
        private MoneyInfoRepository $moneyInfoRepository,
        private MoneyInfoService $moneyInfoService
    ) {
    }

    public function attendance(): bool
    {
        if (!Auth::guard('sanctum')->check()) {
            throw new GraphQLException('계정에 접근 권한이 없습니다.');
        }

        $member = Auth::guard('sanctum')->user();
        $todayRecharge = $this->moneyInfoRepository->sumMoneyPerDay($member, MoneyInfo::TYPE_UD);

        $config = app(BonusConfig::TYPE_ATTENDANCE_BONUS);
        $attendanceEveryDayPaymentAmount = $this->bonusConfigRepository->getValue($config)['attendance_every_day_payment_amount'] ?? 0;
        $bonus_milestone = $this->bonusConfigRepository->getValue($config)['milestone_receives_gift'] ?? [];

        $bonus_date = collect($bonus_milestone)->pluck('day')->toArray();

        if ($todayRecharge < $attendanceEveryDayPaymentAmount) {
            throw new GraphQLException('최소 ' . number_format($attendanceEveryDayPaymentAmount) . '원을 충전하여 출석체크하세요');
        }

        $isAttended = $this->memberAttendanceRepository->isAttended($member->mID);

        if ($isAttended) {
            throw new GraphQLException('오늘 이미 참석하셨습니다.');
        }

        $member->attendances()->create([
            'maRegDate' => date('Y-m-d')
        ]);

        $milestone = $this->memberAttendanceRepository->attendanceInMonth($member->mID, carbon::today()->startOfMonth())->count();
        if (in_array($milestone, $bonus_date)) {
            $reward = collect($bonus_milestone)->where('day', $bonus_date[$milestone])->first();
            $this->moneyInfoService->create([
                'miBankMoney' => $bonus_milestone[$milestone]['value'] ?? 0,
                'miRegDate' => date('Y-m-d'),
                'miWallet' => Member::MEMBER_WALLETS[Member::WALLET_POINT],
                'miType' => MoneyInfo::TYPE_AD,
                'mID' => $member->mID,
                'miBonuses' => [
                    'attendance_bonus' => $reward
                ]
            ]);
        }

        return true;
    }

    public function getCalendar(array $attributes): array
    {
        $start = Carbon::parse($attributes['month'] . '-01');
        $member = Auth::guard('sanctum')->user();
        $today = Carbon::today();

        $config = app(BonusConfig::TYPE_ATTENDANCE_BONUS);
        $bonus_milestone = $this->bonusConfigRepository->getValue($config)['milestone_receives_gift'] ?? [];

        $bonus_date = collect($bonus_milestone)->pluck('day')->toArray();

        $attendances = $this->memberAttendanceRepository->attendanceInMonth($member->mID, $start)->pluck('maRegDate')->mapWithKeys(function ($date) {
            $dateFormatted = $date->format('Y-m-d');
            return [$dateFormatted => true];
        })->all();

        $milestone = count($attendances) > 0 ? count($attendances) : 1;

        $days_in_month = $start->daysInMonth;
        $dates = [];

        $next_bonus = in_array($milestone, $bonus_date) ? $milestone : $this->findClosestGreater($bonus_date, $milestone);

        for ($i = 0; $i < $days_in_month; $i++) {
            $is_bonus = false;
            $day_in_month = $start->copy()->addDays($i)->day;

            $checkMonth = $today->isSameMonth($start) ? $today->copy()->day <= $day_in_month : true;

            if ($checkMonth) {
                if ($next_bonus == $milestone) {
                    $next_bonus = $this->findClosestGreater($bonus_date, $milestone);
                    $is_bonus = true;
                }
                $milestone++;
            }
            $date = $start->copy()->addDays($i)->toDateString();
            $is_attendance = isset($attendances[$date]);
            $today_attendance = $today->toDateString() === $date && $is_attendance;

            $dates[] = [
                'date' => $date,
                'is_attended' => $is_attendance,
                'is_bonus' => $is_bonus,
                'is_today_attendance' => $today_attendance,
            ];
        }

        return $dates;
    }

    private function findClosestGreater($arr, $target)
    {
        $closestGreater = null;

        foreach ($arr as $value) {
            if ($value > $target) {
                if ($closestGreater === null || $value < $closestGreater) {
                    $closestGreater = $value;
                }
            }
        }

        return $closestGreater;
    }
}

<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateBonusCouponRequest;
use App\Models\BonusConfig;
use App\Repositories\BonusConfigRepository;
use App\Services\BonusConfigService;
use Illuminate\Http\Request;

class BonusConfigController extends Controller
{
    public function __construct(
        private BonusConfigService $bonusConfigService,
        private BonusConfigRepository $bonusConfigRepository,
    ) {
    }

    public function indexBonus()
    {
        $config = app(BonusConfig::TYPE_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);

        return view('Admin.PageSetting.BonusConfig.index_bonus', $data);
    }

    public function indexBonusRecharge()
    {
        $config = app(BonusConfig::TYPE_RECHARGE_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);

        return view('Admin.PageSetting.BonusConfig.index_bonus_recharge', $data);
    }

    public function indexBonusSignup()
    {
        $config = app(BonusConfig::TYPE_SIGNUP_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);

        return view('Admin.PageSetting.BonusConfig.index_bonus_signup', $data);
    }

    public function indexBonusParticipate()
    {
        $config = app(BonusConfig::TYPE_PARTICIPATE_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);

        return view('Admin.PageSetting.BonusConfig.index_bonus_participate', $data);
    }

    public function indexBonusNewMember()
    {
        $config = app(BonusConfig::TYPE_NEW_MEMBER_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);

        return view('Admin.PageSetting.BonusConfig.index_bonus_new_member', $data);
    }

    public function indexBonusAttendance()
    {
        $config = app(BonusConfig::TYPE_ATTENDANCE_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);

        return view('Admin.PageSetting.BonusConfig.index_bonus_attendance', $data);
    }

    public function indexBonusReferral()
    {
        $config = app(BonusConfig::TYPE_REFERRAL_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);

        return view('Admin.PageSetting.BonusConfig.index_bonus_referral', $data);
    }

    public function indexBonusHallOfFame()
    {
        $config = app(BonusConfig::TYPE_HALL_OF_FAME_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);

        return view('Admin.PageSetting.BonusConfig.index_bonus_hall_of_fame', $data);
    }

    public function indexBonusConsolationPrize()
    {
        $config = app(BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);

        return view('Admin.PageSetting.BonusConfig.index_bonus_consolation_prize', $data);
    }

    public function indexBonusPayback()
    {
        $config = app(BonusConfig::TYPE_PAYBACK_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);

        return view('Admin.PageSetting.BonusConfig.index_bonus_payback', $data);
    }

    public function indexBonusLevelUp()
    {
        $config = app(BonusConfig::TYPE_LEVEL_UP_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);

        return view('Admin.PageSetting.BonusConfig.index_bonus_level_up', $data);
    }

    public function indexBonusRolling()
    {
        $config = app(BonusConfig::TYPE_ROLLING_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);

        return view('Admin.PageSetting.BonusConfig.index_bonus_rolling', $data);
    }

    public function indexBonusLosing()
    {
        $config = app(BonusConfig::TYPE_LOSING_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);

        return view('Admin.PageSetting.BonusConfig.index_bonus_losing', $data);
    }

    public function indexBonusCoupon()
    {
        $config = app(BonusConfig::TYPE_COUPON_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);

        return view('Admin.PageSetting.BonusConfig.index_bonus_coupon', $data);
    }

    public function indexBonusSudden()
    {
        $config = app(BonusConfig::TYPE_SUDDEN_BONUS);
        $data['data'] = $this->bonusConfigRepository->getValue($config);
        $range_time = $data['data']['sudden_date_time'] ?? null;
        $data['data'] = [...$data['data'], ...convertStringToDateTimeRange($range_time)];

        return view('Admin.PageSetting.BonusConfig.index_bonus_sudden', $data);
    }

    public function toggleField(string $field = null, string $bonusType = null)
    {
        $status = $this->bonusConfigService->toggleField($field, $bonusType);

        return response()->json(['status' => $status]);
    }

    public function toggleJSONField(string $field = null, string $bonusType = null)
    {
        $status = $this->bonusConfigService->toggleFieldInJSON($field, $bonusType);

        return response()->json(['status' => $status]);
    }

    public function updateBonus(Request $request)
    {
        $res = $this->bonusConfigService->updateBonus($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonus')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonus')->with('error', '업데이트 실패');
    }

    public function updateBonusRecharge(Request $request)
    {
        $res = $this->bonusConfigService->updateBonusRecharge($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonusRecharge')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonusRecharge')->with('error', '업데이트 실패');
    }

    public function updateBonusSignup(Request $request)
    {
        $res = $this->bonusConfigService->updateBonusSignup($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonusSignup')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonusSignup')->with('error', '업데이트 실패');
    }

    public function updateBonusParticipate(Request $request)
    {
        $res = $this->bonusConfigService->updateBonusParticipate($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonusParticipate')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonusParticipate')->with('error', '업데이트 실패');
    }

    public function updateBonusNewMember(Request $request)
    {
        $res = $this->bonusConfigService->updateBonusNewMember($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonusNewMember')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonusNewMember')->with('error', '업데이트 실패');
    }

    public function updateBonusAttendance(Request $request)
    {
        $res = $this->bonusConfigService->updateBonusAttendance($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonusAttendance')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonusAttendance')->with('error', '업데이트 실패');
    }

    public function updateBonusReferral(Request $request)
    {
        $res = $this->bonusConfigService->updateBonusReferral($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonusReferral')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonusReferral')->with('error', '업데이트 실패');
    }

    public function updateBonusHallOfFame(Request $request)
    {
        $res = $this->bonusConfigService->updateBonusHallOfFame($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonusHallOfFame')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonusHallOfFame')->with('error', '업데이트 실패');
    }

    public function updateBonusConsolationPrize(Request $request)
    {
        $res = $this->bonusConfigService->updateBonusConsolationPrize($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonusConsolationPrize')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonusConsolationPrize')->with('error', '업데이트 실패');
    }

    public function updateBonusPayback(Request $request)
    {
        $res = $this->bonusConfigService->updateBonusPayback($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonusPayback')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonusPayback')->with('error', '업데이트 실패');
    }

    public function updateBonusLevelUp(Request $request)
    {
        $res = $this->bonusConfigService->updateBonusLevelUp($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonusLevelUp')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonusLevelUp')->with('error', '업데이트 실패');
    }

    public function updateBonusRolling(Request $request)
    {
        $res = $this->bonusConfigService->updateBonusRolling($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonusRolling')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonusRolling')->with('error', '업데이트 실패');
    }

    public function updateBonusLosing(Request $request)
    {
        $res = $this->bonusConfigService->updateBonusLosing($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonusLosing')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonusLosing')->with('error', '업데이트 실패');
    }

    public function updateBonusCoupon(UpdateBonusCouponRequest $request)
    {
        $res = $this->bonusConfigService->updateBonusCoupon($request->all());

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonusCoupon')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonusCoupon')->with('error', '업데이트 실패');
    }

    public function updateBonusSudden(Request $request)
    {
        $request = $request->all();
        $request['sudden_bonus']['sudden_date_time'] = convertDateTimeRangeToString($request['from_date'], $request['from_time'], $request['to_date'], $request['to_time']);
        $res = $this->bonusConfigService->updateBonusSudden($request);

        if ($res) {
            return redirect()->route('admin.page-setting.bonus-config.indexBonusSudden')->with('success', '업데이트 성공');
        }

        return redirect()->route('admin.page-setting.bonus-config.indexBonusSudden')->with('error', '업데이트 실패');
    }

    public function toggleFieldBonusRecharge($level, $group, $field)
    {
        $status = $this->bonusConfigService->toggleFieldBonusRecharge(['level' => $level, 'group' => $group, 'field' => $field]);

        return response()->json(['status' => $status]);
    }

    public function toggleFieldBonusSudden($level, $group, $field)
    {
        $status = $this->bonusConfigService->toggleFieldBonusSudden(['level' => $level, 'group' => $group, 'field' => $field]);

        return response()->json(['status' => $status]);
    }
}

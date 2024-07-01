@php
    $routeName = request()->route()->getName();
@endphp

<div class="p-10">
    <h3 class="cst_h3"><i class="fa fa-gear"></i> 지급포인트설정</h3>
</div>
<div class="box-tool">
    <!-- General management -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonus') }}" @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.bonus-config.indexBonus',
        'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary',
    ])>
        일반 관리
    </a>

    <!-- Deposit Bonus -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonusRecharge') }}" @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.bonus-config.indexBonusRecharge',
        'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary',
    ])>
        입금보너스
    </a>

    <!-- Sign up money -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonusSignup') }}" @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.bonus-config.indexBonusSignup',
        'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary',
    ])>
        가입머니
    </a>

    <!-- Ipple Bonus -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonusParticipate') }}" @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.bonus-config.indexBonusParticipate',
        'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary',
    ])>
        입플보너스
    </a>

    <!-- New bonus -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonusNewMember') }}" @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.bonus-config.indexBonusNewMember',
        'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary',
    ])>
        신규보너스
    </a>

    <!-- Attendance -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonusAttendance') }}" @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.bonus-config.indexBonusAttendance',
        'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary',
    ])>
        출석현활
    </a>

    <!-- Recommend by an acquaintance -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonusReferral') }}" @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.bonus-config.indexBonusReferral',
        'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary',
    ])>
        지인추천
    </a>

    <!-- Hall of fame -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonusHallOfFame') }}" @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.bonus-config.indexBonusHallOfFame',
        'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary',
    ])>
        명예의 전당
    </a>

    <!-- Consolation prize -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonusConsolationPrize') }}" @class([
        'btnstyle1-success active-success' =>
            $routeName ==
            'admin.page-setting.bonus-config.indexBonusConsolationPrize',
        'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary',
    ])>
        위로금
    </a>

    <!-- Payback -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonusPayback') }}" @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.bonus-config.indexBonusPayback',
        'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary',
    ])>
        페이백
    </a>

    <!-- TODO:SADSAD -->
    <!-- Level up -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonusLevelUp') }}" @class(['btnstyle1-success active-success' => $routeName == 'admin.page-setting.bonus-config.indexBonusLevelUp', 'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary'])>
        레벨업
    </a>

    <!-- Rolling point -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonusRolling') }}" @class(['btnstyle1-success active-success' => $routeName == 'admin.page-setting.bonus-config.indexBonusRolling', 'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary'])>
        롤링포인트
    </a>

    <!-- Losing points -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonusLosing') }}" @class(['btnstyle1-success active-success' => $routeName == 'admin.page-setting.bonus-config.indexBonusLosing', 'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary'])>
        낙첨포인트
    </a>

    <!-- Coupon -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonusCoupon') }}" @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.bonus-config.indexBonusCoupon',
        'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary',
    ])>
        쿠폰
    </a>

    <!-- Sudden bonus -->
    <a href="{{ route('admin.page-setting.bonus-config.indexBonusSudden') }}" @class([
        'btnstyle1-success active-success' =>
            $routeName == 'admin.page-setting.bonus-config.indexBonusSudden',
        'btnstyle1 btnstyle1-sm height-28 m-l-2 m-r-2 m-w-80 btnstyle1-primary',
    ])>
        돌발보너스
    </a>
</div>

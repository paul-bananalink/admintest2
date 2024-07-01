<!-- BEGIN Navbar -->
<div id="navbar" class="navbar">
    <div id="navbar" class="flex space-between height-full items-center" style="padding-right:0">
        {{-- <div>
            Partner
        </div>

        <!-- BEGIN Navbar Buttons -->
        <div class="nav spobulls-nav pull-right">
            
            <!-- END Button User -->
        </div> --}}
        <!-- END Navbar Buttons -->

        <div class="flex-1">
            <div class="f-s-21 text-light font-bold"><a href="{{ route('partner.dashboard.index') }}"
                    class="text-light"><span class="text-blue-1 f-s-30"
                        style="font-family: arial; padding-left:10px">PARTNER ::</span>
                    LV.{{ auth('partner')->user()->mLevel }} 테스트스트 님~ 수익배분(입금-출금)</a></div>
        </div>
        <div>
            <a href="{{ route('partner.logout') }}" class="btnstyle1-danger btnstyle1-sm m-0">
                <i class="fa fa-power-off text-inverse m-t-6 f-s-14 text-dark mr-3"></i> 로그아웃
            </a>
        </div>
    </div>
</div>

<div id="top-menu" class="animated fadeInDownBig top-menu">
    <ul class="nav width-full">

        {{-- Notice --}}
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('partner.notice.index'),
            'text' => '파트너공지사항',
            'icon' => '<i class="ion-coffee text-warning"></i>',
            'badge' => false,
        ])

        {{-- Member list --}}
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('partner.status-members.index'),
            'text' => '회원관리',
            'icon' => '<i class="ion-person-stalker text-warning m-r-4 f-s-16"></i>',
            'badge' => false,
        ])

        {{-- Partner --}}
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('partner.manager.index'),
            'text' => '파트너관리',
            'icon' => '<i class="fa ion-person-add text-warning"></i>',
            'badge' => false,
        ])

        {{-- Coupon --}}
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('partner.coupon.index'),
            'text' => '쿠폰관리',
            'icon' => '<i class="fa text-warning text-warning"><strong>ⓟ</strong></i>',
            'badge' => false,
        ])

        {{-- Recharge --}}
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('partner.money-info.index', 'recharge'),
            'text' => '입금관리',
            'icon' => '<i class="ion-android-add-circle text-warning"></i>',
            'badge' => false,
        ])

        {{-- Withdraw --}}
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('partner.money-info.index', 'withdraw'),
            'text' => '출금관리',
            'icon' => '<i class="ion-android-remove-circle text-warning"></i>',
            'badge' => false,
        ])

        {{-- Sport --}}
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            'text' => '스포츠',
            'badge' => false,
            'icon' => '<i class="ion-ios-football text-warning"></i>',
            'number' => 0,
        ])

        {{-- Realtime --}}
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            'text' => '실시간',
            'badge' => false,
            'icon' => '<i class="ion-ios-basketball text-warning"></i>',
            'number' => 0,
        ])

        {{-- PArsing casino --}}
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#', //route('partner.betting-histories.parsingCasino'),
            'text' => '파싱카지노',
            'badge' => false,
            'icon' => '<i class="ion-playstation text-warning"></i>',
        ])

        {{-- Cash --}}
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('partner.cash.index'),
            'text' => '캐쉬관리',
            'icon' => '<i class="ion-social-usd text-warning"></i>',
            'badge' => false,
        ])

        {{-- Bonus --}}
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            // 'text' => '포인트',
            'text' => '보너스관리',
            'badge' => false,
            'icon' => '<i class="fa text-warning m-r-6 f-s-16"><strong>ⓟ</strong></i>',
            'subMenu' => [
                [
                    'title' => '포인트',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'bonus_all']),
                ],
                [
                    'title' => '가입머니',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'casino_first_time_recharge_bonus']),
                ],
                [
                    'title' => '가입머니',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'casino_next_time_recharge_bonus']),
                ],
                [
                    'title' => '가입머니',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'signup_bonus']),
                ],
                [
                    'title' => '입플보너스',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'participate_bonus']),
                ],
                [
                    'title' => '신규보너스',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'new_member_bonus']),
                ],
                [
                    'title' => '출석현황',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'attendance_bonus']),
                ],
                [
                    'title' => '지인추천1',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'referral_1_bonus']),
                ],
                [
                    'title' => '지인추천2',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'referral_2_bonus']),
                ],
                [
                    'title' => '명예의 전당',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'hall_of_fame_bonus']),
                ],
                [
                    'title' => '위로금',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'consolation_prize_bonus']),
                ],
                [
                    'title' => '페이백',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'payback_bonus']),
                ],
                [
                    'title' => '롤링포인트',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'rolling_bonus']),
                ],
                [
                    'title' => '낙첨포인트',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'losing_bonus']),
                ],
                // [
                //     'title' => '레벨업',
                //     'routeURL' => route('partner.point-history.index', ['filter' => 'level_up_bonus']),
                // ],
                [
                    'title' => '쿠폰현황 및 지급',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'coupon_and_payment_bonus']),
                ],
                [
                    'title' => '돌발보너스',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'sudden_bonus']),
                ],
                [
                    'title' => '파트너롤링 쉐어',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'partner_share_bonus']),
                ],
                [
                    'title' => '월출석현황',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'monthly_attendance_bonus']),
                ],
                [
                    'title' => '관리자지급',
                    'routeURL' => route('partner.point-history.index', ['filter' => 'admin_recharge']),
                ],
            ],
        ])

        {{-- Minigame --}}
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            'text' => '미니게임배팅',
            'icon' => '<i class="ion-trophy text-warning"></i>',
            'badge' => false,
        ])


        {{-- Casino betting --}}
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('partner.betting-histories.casino'),
            'text' => '카지노배팅',
            'icon' => '<i class="ion-playstation text-warning"></i>',
            'badge' => false,
        ])

        {{-- Settlement --}}
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            'text' => '정산관리',
            'icon' => '<i class="ion-clipboard text-warning"></i>',
            'badge' => false,
            'subMenu' => [
                ['title' => '사이트 일일 정산', 'routeURL' => route('partner.settlement.index'), 'isMaintaining' => true],
                ['title' => '포커 일일 정산', 'routeURL' => route('partner.settlement.index'), 'isMaintaining' => true],
            ],
        ])

        {{-- @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('partner.dashboard.index'),
            'text' => '현황',
            'icon' => '<i class="fa ion-pie-graph text-warning"></i>',
            'badge' => false,
        ])

        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            'text' => '파트너공지',
            'icon' => '<i class="fa fa-envelope text-warning"></i>',
            'badge' => false,
        ])

        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('partner.status-members.index'),
            'text' => '회원',
            'icon' => '<i class="fa ion-person-stalker text-warning"></i>',
            'badge' => false,
        ])

        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('partner.manager.index'),
            'text' => '파트너관리',
            'icon' => '<i class="fa ion-person-add text-warning"></i>',
            'badge' => false,
        ])

        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            'text' => '쿠폰관리',
            'icon' => '<i class="fa fa-ticket text-warning"></i>',
            'badge' => false,
        ])





        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            'text' => '미니',
            'icon' => '<i class="ion-person-stalker text-warning"></i>',
            'badge' => false,
        ])

        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('partner.betting-histories.casino'),
            'text' => '카지노',
            'icon' => '<i class="ion-person-stalker text-warning"></i>',
            'badge' => false,
        ])

        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            'text' => '정산',
            'icon' => '<i class="ion-person-stalker text-warning"></i>',
            'badge' => false,
        ]) --}}
    </ul>
</div>

<!-- END Navbar -->

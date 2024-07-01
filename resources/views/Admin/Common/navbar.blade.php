<div id="navbar" class="navbar">
    <div class="pull-left">
        <a href="#" class="btn btnstyle1-inverse2 f-s-11" data-target="#modal_export_member_excel"
            data-toggle="modal">
            <i class="fa fa-file-excel-o text-info-1 mr-3"></i> 엑셀
        </a>
        @include('Admin.Common.navbar_button_active', [
            'routeName' => config('constant_view.ROUTE_NAME.ADMIN_DASHBOARD_INDEX'),
            'routeURL' => route('admin.dashboard.index'),
            'text' => '현황',
            'icon' => '<i class="fa ion-pie-graph text-info-1 mr-3"></i>',
        ])
        @php
            if (request()->is('admin/page-setting/*')) {
                $pageSettingUrl = Route::currentRouteName();
            }
        @endphp
        @include('Admin.Common.navbar_button_active', [
            'routeName' => $pageSettingUrl ?? config('constant_view.ROUTE_NAME.ADMIN_PAGE_SETTING_INDEX'),
            'routeURL' => route('admin.page-setting.index'),
            'text' => '옵션',
            'icon' => '<i class="fa fa-cogs text-info-1 mr-3"></i>',
        ])
        @php
            if (request()->is('admin/note/*')) {
                $noteUrl = Route::currentRouteName();
            }
        @endphp
        @include('Admin.Common.navbar_button_active', [
            'routeName' => $noteUrl ?? config('constant_view.ROUTE_NAME.ADMIN_PAGE_NOTE_INDEX'),
            'routeURL' => route('admin.note.index'),
            'text' => '쪽지',
            'icon' => '<i class="fa fa-envelope text-info-1 mr-3"></i>',
        ])
        @include('Admin.Common.navbar_button_active', [
            'routeName' => config('constant_view.ROUTE_NAME.ADMIN_PAGE_POPUP_INDEX'),
            'routeURL' => route('admin.popup.index'),
            'text' => '팝업',
            'icon' => '<i class="fa fa-envelope text-info-1 mr-3"></i>',
        ])

        @include('Admin.Common.navbar_button_active', [
            'routeName' => config('constant_view.ROUTE_NAME.ADMIN_INFO_MEMBER_BLOCK_INDEX'),
            'routeURL' => route('admin.info-member-block.index'),
            'text' => '접속',
            'icon' => '<i class="fa fa-floppy-o text-info-1 mr-3"></i>',
            'badge' => true,
            'number' => 0,
        ])

        @include('Admin.Common.navbar_button_active', [
            'routeName' => config('constant_view.ROUTE_NAME.ADMIN_PAGE_MEMBERS_IP_INFECT_INDEX'),
            'routeURL' => route('admin.members-ip-infect.index'),
            'text' => '중복아이피',
            'icon' => '<i class="fa fa-user text-info-1 mr-3"></i>',
        ])
        @include('Admin.Common.navbar_button_active', [
            'routeName' => config('constant_view.ROUTE_NAME.ADMIN_PAGE_BLACKLIST_INDEX'),
            'routeURL' => route('admin.blacklist.index'),
            'text' => '알박이',
            'icon' => '<i class="fa fa-trash text-info-1 mr-3"></i>',
        ])
        @include('Admin.Common.navbar_button_active', [
            'routeName' => '',
            'routeURL' => '#',
            'text' => '스포츠',
            'icon' => '<i class="fa fa-signal text-info-1 mr-3"></i>',
            'number' => 0,
            'badge' => true,
        ])
        @include('Admin.Common.navbar_button_active', [
            'routeName' => '',
            'routeURL' => '#',
            'text' => '실시간',
            'icon' => '<i class="fa fa-signal text-info-1 mr-3"></i>',
            'number' => 0,
            'badge' => true,
        ])

    </div>
    <!-- BEGIN Navbar Buttons -->
    <div class="nav spobulls-nav pull-right">
        <a href="{{ route('admin.logout') }}" class="btnstyle1-danger btnstyle1-sm m-0">
            <i class="fa fa-power-off text-inverse m-t-6 f-s-14 text-dark"></i>
        </a>
        <!-- END Button User -->
    </div>
    <!-- END Navbar Buttons -->

</div>
<div class="skin-black cst_navbar_text">
    <span class="green">TODAY : </span>
    <span>회원가입(승인)1: <span class="text-warning rg_u">{{ $count_member_register_today }}</span><span
            class="rg_u_approved text-warning">({{ $count_member_register_approved_today }})</span>
        <span class="cst_divide">/</span>

        <span>입금 : </span>
        <span class="blue deposit_today">{{ formatNumber($getSumMoneyDepositeRegisterToday) }}</span>
        <span class="deposit_application_number color-gray">({{ $getCountOrderDepositRegisterToday }})</span>
        <span class="cst_divide">/</span>

        <span>출금 : </span>
        <span class="red withdraw_today">{{ formatNumber($getMoneyOrderWithdrawRegisterToday) }}</span>
        <span class="order_withdraw_today color-gray">({{ formatNumber($getCountOrderWithdrawRegisterToday) }})</span>
        <span class="cst_divide">/</span>

        <span>수익(입-출) : </span>
        <span class="blue profits_today">{{ formatNumber($profitAmountToday) }}</span>
        <span class="cst_divide">/</span>

        <span>배팅 : </span>
        <span class="text-blue-1">258,930,000</span>
        <span class="color-gray">(1266)</span>
        <span>/</span>
        <span class="red">-258,930,000</span>
        <span class="color-gray">(1266)</span>
        <span class="cst_divide">/</span>

        <span>당첨 : </span>
        <span class="red">-258,930,000</span>
        <span class="color-gray">(1266)</span>
        <span class="cst_divide">/</span>

        <span>승률(배-당) : </span>
        <span class="blue">258,930,000</span>
        <span class="cst_divide">/</span>

        <span>회원보유액 : </span>
        <span class="text-blue-1 sum_money_all_member">{{ formatNumber($getSumMoneyAllMember) }}</span>
</div>

<div id="top-menu" class="animated fadeInDownBig top-menu">
    <ul class="nav">
        @include('Admin.Common.navbar_child_active', [
            'id' => 'member',
            'routeName' => config('constant_view.ROUTE_NAME.ADMIN_PAGE_STATUS_MEMBERS_INDEX'),
            'routeURL' => route('admin.status-members.index'),
            'text' => '회원',
            'badge' => false,
            'number' => $totalPendingMember,
            'icon' => '<i class="ion-person-stalker text-warning"></i>',
        ])
        @include('Admin.Common.navbar_child_active', [
            'routeName' => config('constant_view.ROUTE_NAME.ADMIN_PAGE_MEMBER_PARTNER_INDEX'),
            'routeURL' => route('admin.partner.index'),
            'text' => '파트너',
            'badge' => false,
            'icon' => '<i class="fa ion-person-add text-warning"></i>',
        ])
        @php
            if (request()->is('admin/consultation/*') || request()->is('admin/template-message/*')) {
                $consultationUrl = url()->current();
            }
        @endphp
        @include('Admin.Common.navbar_child_active', [
            'id' => 'consultation',
            'routeURL' => route('admin.consultation.index'),
            'text' => '1:1문의',
            'badge' => false,
            'number' => $totalConsultation,
            'activeUrl' => $consultationUrl ?? route('admin.consultation.index'),
            'icon' => '<i class="ion-chatbubbles text-warning"></i>',
        ])
        @include('Admin.Common.navbar_child_active', [
            'id' => 'UD',
            'routeName' => config('constant_view.ROUTE_NAME.ADMIN_PAGE_MONEYINFO_INDEX'),
            'routeURL' => route('admin.money-info.index', 'recharge'),
            'text' => '입금',
            'badge' => false,
            'number' => $totalMoneyInfo['recharge'],
            'icon' => '<i class="ion-android-add-circle text-warning"></i>',
        ])
        @include('Admin.Common.navbar_child_active', [
            'id' => 'UW',
            'routeName' => config('constant_view.ROUTE_NAME.ADMIN_PAGE_MONEYINFO_INDEX'),
            'routeURL' => route('admin.money-info.index', 'withdraw'),
            'text' => '출금',
            'badge' => false,
            'number' => $totalMoneyInfo['withdraw'],
            'icon' => '<i class="ion-android-remove-circle text-warning"></i>',
        ])
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            'text' => '스포츠',
            'badge' => false,
            'icon' => '<i class="ion-ios-football text-warning"></i>',
            'number' => 4,
        ])
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            'text' => '실시간',
            'badge' => false,
            'icon' => '<i class="ion-ios-basketball text-warning"></i>',
            'number' => 4,
        ])
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            'text' => '미니게임',
            'badge' => false,
            'icon' => '<i class="ion-trophy text-warning"></i>',
            'number' => 0,
        ])
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('admin.betting-histories.parsingCasino'),
            'activeUrl' => route('admin.betting-histories.parsingCasino'),
            'text' => '파싱카지노',
            'badge' => false,
            'icon' => '<i class="ion-playstation text-warning"></i>',
        ])
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('admin.betting-histories.casino'),
            'text' => '카지노',
            'badge' => false,
            'icon' => '<i class="ion-playstation text-warning"></i>',
        ])
        @php
            if (request()->is('admin/news-board/*') || request()->is('admin/event/*')) {
                $eventUrl = url()->current();
            }
        @endphp
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            'text' => '게시판',
            'badge' => false,
            'activeUrl' => $eventUrl ?? route('admin.news-board.index'),
            'icon' => '<i class="ion-coffee text-warning"></i>',
            'subMenu' => [
                ['title' => '공지/규정', 'routeURL' => route('admin.notice.rule.index')],
                ['title' => '파트너공지사항', 'routeURL' => route('admin.notice.partner.index')],
                ['title' => '이벤트존', 'routeURL' => route('admin.notice.event.index')],
                ['title' => '자유게시판', 'routeURL' => route('admin.notice.vote.index')],
            ],
        ])
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            'text' => '보너스',
            'badge' => false,
            'icon' => '<i class="fa text-warning m-r-6 f-s-16"><strong>ⓟ</strong></i>',
            'subMenu' => [
                [
                    'title' => '보너스',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'bonus_all']),
                ],
                [
                    'title' => '가입머니',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'casino_first_time_recharge_bonus']),
                ],
                [
                    'title' => '가입머니',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'casino_next_time_recharge_bonus']),
                ],
                [
                    'title' => '가입머니',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'signup_bonus']),
                ],
                [
                    'title' => '입플보너스',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'participate_bonus']),
                ],
                [
                    'title' => '신규보너스',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'new_member_bonus']),
                ],
                [
                    'title' => '출석현황',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'attendance_bonus']),
                ],
                [
                    'title' => '지인추천1',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'referral_1_bonus']),
                ],
                [
                    'title' => '지인추천2',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'referral_2_bonus']),
                ],
                [
                    'title' => '명예의 전당',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'hall_of_fame_bonus']),
                ],
                [
                    'title' => '위로금',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'consolation_prize_bonus']),
                ],
                [
                    'title' => '페이백',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'payback_bonus']),
                ],
                [
                    'title' => '롤링포인트',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'rolling_bonus']),
                ],
                [
                    'title' => '낙첨포인트',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'losing_bonus']),
                ],
                // [
                //     'title' => '레벨업',
                //     'routeURL' => route('admin.point-history.index', ['filter' => 'level_up_bonus']),
                // ],
                [
                    'title' => '쿠폰현황 및 지급',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'coupon_and_payment_bonus']),
                ],
                [
                    'title' => '돌발보너스',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'sudden_bonus']),
                ],
                [
                    'title' => '파트너롤링 쉐어',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'partner_share_bonus']),
                ],
                [
                    'title' => '월출석현황',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'monthly_attendance_bonus']),
                ],
                [
                    'title' => '관리자지급',
                    'routeURL' => route('admin.point-history.index', ['filter' => 'admin_recharge']),
                ],
            ],
        ])
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => '#',
            'text' => '게임',
            'badge' => false,
            'icon' => '<i class="ion-podium text-warning"></i>',
            'subMenu' => [
                ['title' => '스포츠', 'routeURL' => route('admin.sport.index', ['type' => 'sport'])],
                ['title' => '실시간', 'routeURL' => route('admin.sport.index', ['type' => 'realtime'])],
                ['title' => '리그', 'routeURL' => route('admin.sport.index', ['type' => 'league'])],
                ['title' => '팀', 'routeURL' => route('admin.sport.index', ['type' => 'team'])],
            ],
        ])
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('admin.cash.index'),
            'text' => '캐쉬',
            'badge' => false,
        ])
        @include('Admin.Common.navbar_child_active', [
            'routeURL' => route('admin.settlement.index'),
            'text' => '정산',
            'badge' => false,
            'icon' => '<i class="ion-clipboard text-warning"></i>'
        ])
    </ul>
</div>

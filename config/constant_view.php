<?php

return [
    'ROUTE_NAME' => [
        'ADMIN_DASHBOARD_INDEX' => 'admin.dashboard.index',
        'ADMIN_PAGE_SETTING_INDEX' => 'admin.page-setting.index',
        'ADMIN_PAGE_NOTE_INDEX' => 'admin.note.index',
        'ADMIN_PAGE_CONSULTATION_INDEX' => 'admin.consultation.index',
        'ADMIN_INFO_MEMBER_ACCESS_INDEX' => 'admin.info-member-access.index',
        'ADMIN_INFO_MEMBER_BLOCK_INDEX' => 'admin.info-member-block.index',
        'ADMIN_PAGE_EVENT_INDEX' => 'admin.event.index',
        'ADMIN_PAGE_NEWSBOARD_INDEX' => 'admin.news-board.index',
        'ADMIN_PAGE_MONEYINFO_INDEX' => 'admin.money-info.index',
        'ADMIN_PAGE_MEMBERS_IP_INFECT_INDEX' => 'admin.members-ip-infect.index',
        'ADMIN_PAGE_STATUS_MEMBERS_INDEX' => 'admin.status-members.index',
        'ADMIN_PAGE_MEMBER_PARTNER_INDEX' => 'admin.partner.index',
        'ADMIN_PAGE_TEMPLATE_MESSAGE_INDEX' => 'admin.template-message.index',
        'ADMIN_PAGE_POPUP_INDEX' => 'admin.popup.index',
        'ADMIN_PAGE_BONUS_INDEX' => 'admin.bonus.index',
        'ADMIN_PAGE_BLACKLIST_INDEX' => 'admin.blacklist.index'
    ],
    'VIEW' => [
        'selectSiTimeOUt' => [120, 60, 30],
        'selectMLevel' => ['AD'],
        'M_LEVEL_MA' => 'MA',
        'selectFieldSearch' => [
            99 => '전체',
            'member_id' => '아이디',
            'ip' => 'IP',
            'member_header_access' => 'Header 정보',
            'login_date' => '일시',
        ],
        'SELECT_ALL_FIELD' => 99,
        'WHERE_COLUMN_M_ID' => 'member_id',
        'WHERE_COLUMN_ML_IPV4' => 'ip',
        'WHERE_COLUMN_ML_BROWSER_SYSTEM' => 'member_header_access',
        'WHERE_COLUMN_ML_UPDATED_AT' => 'login_date',
        'MEMBER_ACTIVE' => '접속중',
        'MEMBER_LOGOUTED' => '로그아웃',
        'selectFieldMember' => [
            // 99 => '선택',
            'm_id' => '아이디', //ID
            'm_casino_id' => '카지노아이디', //Casino ID
            'm_partner' => '파트너명', //partner
            'm_nick' => '닉네임', //nickname
            'm_real_name' => '이름', //mID
            'm_member_invite' => '추천인', //member inviting
            'm_level' => '레벨', //level
            'm_ip' => '아이피', //ip
            'm_phone' => '전화번호', //phone number
            'm_bank_number' => '계좌번호', //bank number
            'm_note' => '메모', //Admin memo
            'm_bank_name' => '은행', //Bank
        ],
    ],
    'GUARD' => [
        'ADMIN' => 'admin',
        'GUEST' => 'guest',
        'SANCTUM' => 'sanctum',
        'PARTNER' => 'partner',
    ],
    'QUERY_DATABASE' => [
        'ASC' => 'asc',
        'DESC' => 'desc',
    ],
    'EVENTS' => [
        'TURN_ON_EVENT' => true,
        'TURN_OFF_EVENT' => false,
    ],
    'BANKS' => [
        'KB국민은행',
        '우리은행',
        'SC제일은행',
        '한국씨티은행',
        '하나은행',
        '신한은행',
        '케이뱅크',
        '카카오뱅크',
        '토스뱅크',
        '산업은행',
        '기업은행',
        '한국수출입은행',
        '수협은행',
        'NH농협은행',
        '대구은행',
        '부산은행',
        '경남은행',
        '광주은행',
        '전북은행',
        '제주은행'
    ],
    'DEFAULT_PASSWORD' => 'User@12345',
    'SELECT_PER_PAGE' => [
        30 => '30 / Page',
        50 => '50 / Page',
        100 => '100 / Page',
        300 => '300 / Page',
    ],
    'PAGE_PARTNER' => [
        'all' => [
            'key' => 'all',
            'title' => '전체'
        ],
        'deputy_headquarters' => [
            'key' => 'deputy_headquarters',
            'title' => '부본사'
        ],
        'distributor' => [
            'key' => 'distributor',
            'title' => '총판',
        ],
        'agency' => [
            'key' => 'agency',
            'title' => '대리점'
        ],
    ],

    'PARTNER_PROFIT_TYPE' => [
        \App\Models\Partner::PROFIT_SHARE => '수익배분',
        \App\Models\Partner::PROFIT_BET => '롤링지급',
    ],
    'MODAL_EXPORT_EXCEL' => [
        'TYPE_MEMBER' => [
            'all_member' => '전체회원',
            'member_logged_5days_ago' => '5회/7일 미접속회원',
            'member_normal' => '정상회원만',
            'member_stop' => '차단회원만',
            'member_reject_register' => '탈퇴회원만',
            'member_logged_10days_ago' => '장기미접속회원만',
            'member_recharge' => '실입금회원만',
        ],
        'OPTION_MEMBER' => [
            'partner_parent' => '파트너명',
            'mMemberID' => '추천인',
            'mLevel' => '레벨',
            'mNick' => '닉네임',
            'mID' => '아이디',
            'mPhone' => '전화번호',
            'mBankName' => '은행',
            'mBankNumber' => '계좌번호',
            'mBankOwner' => '예급주',
            'miType_UD_AD' => '입금',
            'miType_UW_AW' => '출금',
            'win_ratio' => '승률',
            // 'mSportsMoney' => '스포츠캐쉬',
            'mMoney' => '현재보유캐쉬',
            'mRegDate_mApproveRegDate' => '가입일시/허가일시',
            'mRegDate' => '가입일시',
            'mApproveRegDate' => '허가일시',
            'mLoginDateTime' => '최근접속일',
            'mNote' => '메모',
            'mStatus' => '상태',
        ]
    ],
    'NOTICE_CATEGORY' => [
        'RULES' => [
            'notice' => '공지사항',
            'betting_rules' => '배팅규정',
            'user_guide' => '이용안내',
            'faq' => 'FAQ',
        ],
        'EVENTS' => [
            'new' => '신규',
            'rank' => '등급',
            'special' => '특별',
            'mini_game' => '미니게임',
            'casino' => '카지노',
            'season_event' => '시즌이벤트',
            'on_going' => '진행중'
        ]
    ],
    'MAX_BETTING_VALUES' => [
        0,
        10000,
        20000,
        30000,
        40000,
        50000,
        60000,
        70000,
        80000,
        90000,
        100000,
        200000,
        300000,
        400000,
        500000,
        600000,
        700000,
        800000,
        900000,
        1000000,
        10000000,
    ],
    'MEMBER_STATUS' => [
        'normal' => [
            'kr_text' => '정상',
            'badge_type' => 'primary',
        ],
        'pending' => [
            'kr_text' => '대기',
            'badge_type' => 'info',
        ],
        'blocked' => [
            'kr_text' => '차단',
            'badge_type' => 'danger',
        ],
        'force_logout' => [
            'kr_text' => '탈퇴',
            'badge_type' => 'normal',
        ],
        'albagi' => [
            'kr_text' => '알박이',
            'badge_type' => 'warning',
        ],
    ],
    'BONUS_PARTICIPATE' => [
        'ipl_bonus_plus_percent' => [1, 3, 5, 10, 20, 30, 50, 100, 200]
    ],
    'BONUS_ATTENDANCE' => range(0, 9),
    'BONUS_NEW_MEMBER' => [
        'new_member_bonus_plus_percent' => [3, 5, 10, 20, 30, 50, 100]
    ],
];

<?php
return [
    'LEVELS' => range(1, 20),
    'WITHDRAW' => [
        'ROLLING_SETTING' => [
            'BONUS_TYPES' => [
                'NO_BONUS' => '보너스 없음',
                'RECEIVE_BONUS' => '보너스 받음'
            ],
            'BET_TYPES' => [
                'first' => [
                    'sports' => ['label' => '스포츠단폴', 'type' => 'input'],
                    'realtime_single_poll' => ['label' => '실시간단폴', 'type' => 'input'],
                    'sports_multi_pole' => ['label' => '스포츠다폴', 'type' => 'input'],
                    'realtime_multi_poll' => ['label' => '실시간다폴', 'type' => 'input'],
                    'mini_game' => ['label' => '미니게임', 'type' => 'input'],
                    'virtual_sports' => ['label' => '가상스포츠', 'type' => 'input'],
                    'parsing_casino' => ['label' => '파싱카지노', 'type' => 'input'],
                    'casino' => ['label' => '카지노', 'type' => 'input'],
                ],
                'seconds' => [
                    'number_of_poker_hands' => ['label' => '핸드 수', 'type' => 'input'],
                    'poker_rolling_rate' => ['label' => '롤링 요율', 'type' => 'input'],
                ]
            ]
        ]
    ],
    'RECHARGE_BONUS_WARNING_MESSAGE' => [
        'no_bonus' => '보너스 없음',
        'first_recharge_sports' => '스포츠 첫총',
        'first_recharge_casino' => '카지노 첫충',
        'sports_every_floor' => '스포츠 ',
        'casino_every_floor' => '카지노 매총',
        'recharge_bonus' =>  '입플',
        'new_member' => '신규',
        'no_bonus_poker' => '포커 보너스 없음',
        'first_recharge_poker' => '포커 첫총',
        'poker_every_floor' => '포커 매총',
    ],
    'MENU_LIST' => [
        'disabled' => '사용안함',
        'sports' => '스포츠',
        'live' => '실시간',
        'mini_game' => '미니게임',
        'virtual_sports' => '가상스포츠',
        'casino' => '카지노',
        'poker' => '포커',
        'inquiry' => '문의',
        'event' => '이벤트',
        'deposit' => '입금',
        'withdrawal' => '출금',
        'money_transfer' => '머니이동',
        'betting_history' => '배팅내역',
        'transaction_history' => '거래내역',
        'notice' => '공지사항',
        'message' => '쪽지',
        'attendance_status' => '출석현황',
        'coupon_point' => '쿠폰/포인트',
        'hall_of_fame' => '명예의전당',
        'friend_recommendation' => '지인추천'
    ],
    'TARGET' => [
        'disable' => '사용않합',
        'blank' => '새창',
        'self' => '현재창'
    ],
    'STATUS' => [
        'enable' => '사용',
        'disable' => '사용않합'
    ],
    'SUSPICION_LIST' => [
        '양방의심1',
        '양방의심2',
        '양방의심3',
        '양방의심4'
    ]
];

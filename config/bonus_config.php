<?php

return [
    
    'bonus' => [
        'is_reset_rolling_bonus_is_paid' => [
            'cast' => 'boolean',
        ],
        'is_check_balance_upon_payout' => [
            'cast' => 'boolean',
        ],
        'paid_amount' => [
            'cast' => 'float',
        ],
    ],

    'recharge_bonus' => [
        'weekday_rate.*.sports_first_time_recharge' => [
            'cast' => 'integer',
        ],
        'weekday_rate.*.sports_recharge' => [
            'cast' => 'integer',
        ],
        'weekday_rate.*.casino_first_time_recharge' => [
            'cast' => 'integer',
        ],
        'weekday_rate.*.casino_recharge' => [
            'cast' => 'integer',
        ],
        'weekday_rate.*.poker_first_time_recharge' => [
            'cast' => 'integer',
        ],
        'weekday_rate.*.poker_recharge' => [
            'cast' => 'integer',
        ],

        'weekend_rate.*.sports_first_time_recharge' => [
            'cast' => 'integer',
        ],
        'weekend_rate.*.sports_recharge' => [
            'cast' => 'integer',
        ],
        'weekend_rate.*.casino_first_time_recharge' => [
            'cast' => 'integer',
        ],
        'weekend_rate.*.casino_recharge' => [
            'cast' => 'integer',
        ],
        'weekend_rate.*.poker_first_time_recharge' => [
            'cast' => 'integer',
        ],
        'weekend_rate.*.poker_recharge' => [
            'cast' => 'integer',
        ],

        'is_payment_upon_withdraw.*.sports_first_time_recharge' => [
            'cast' => 'boolean'
        ],
        'is_payment_upon_withdraw.*.sports_recharge' => [
            'cast' => 'boolean'
        ],
        'is_payment_upon_withdraw.*.casino_first_time_recharge' => [
            'cast' => 'boolean'
        ],
        'is_payment_upon_withdraw.*.casino_recharge' => [
            'cast' => 'boolean'
        ],
        'is_payment_upon_withdraw.*.poker_first_time_recharge' => [
            'cast' => 'boolean'
        ],
        'is_payment_upon_withdraw.*.poker_recharge' => [
            'cast' => 'boolean'
        ],
    ],

    'signup_bonus' => [
        'new_membership_signup_money' => [
            'cast' => 'integer',
        ],
        'minimum_sports_folder' => [
            'cast' => 'integer',
        ],
        'minimum_payout' => [
            'cast' => 'integer',
        ],
        'membership_fee_regulation' => [
            'cast' => 'string',
        ],
        'is_recommended_by_acquaintances_membership_bonuses' => [
            'cast' => 'boolean',
        ],
        'is_sports_betting' => [
            'cast' => 'boolean',
        ],
        'is_realtime_betting' => [
            'cast' => 'boolean',
        ],
        'is_minigame_betting' => [
            'cast' => 'boolean',
        ],
        'is_virtual_sports_betting' => [
            'cast' => 'boolean',
        ],
        'is_casino_betting' => [
            'cast' => 'boolean',
        ],
        'is_parsing_casino_betting' => [
            'cast' => 'boolean',
        ],
    ],

];

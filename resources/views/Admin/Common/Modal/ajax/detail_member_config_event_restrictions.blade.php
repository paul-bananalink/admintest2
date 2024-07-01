@use('App\Models\BonusConfig')

<tr>
    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_BONUS) }}"
            id="{{ BonusConfig::TYPE_BONUS }}"
            name="{{ BonusConfig::TYPE_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_RECHARGE_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_RECHARGE_BONUS) }}"
            id="{{ BonusConfig::TYPE_RECHARGE_BONUS }}"
            name="{{ BonusConfig::TYPE_RECHARGE_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_RECHARGE_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_CASINO_FIRST_TIME_RECHARGE] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_CASINO_FIRST_TIME_RECHARGE) }}"
            id="{{ BonusConfig::TYPE_CASINO_FIRST_TIME_RECHARGE }}"
            name="{{ BonusConfig::TYPE_CASINO_FIRST_TIME_RECHARGE }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_CASINO_FIRST_TIME_RECHARGE]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_CASINO_NEXT_TIME_RECHARGE] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_CASINO_NEXT_TIME_RECHARGE) }}"
            id="{{ BonusConfig::TYPE_CASINO_NEXT_TIME_RECHARGE }}"
            name="{{ BonusConfig::TYPE_CASINO_NEXT_TIME_RECHARGE }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_CASINO_NEXT_TIME_RECHARGE]) }}"
        />
    </td>
</tr>

<tr>
    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_SIGNUP_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_SIGNUP_BONUS) }}"
            id="{{ BonusConfig::TYPE_SIGNUP_BONUS }}"
            name="{{ BonusConfig::TYPE_SIGNUP_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_SIGNUP_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_PARTICIPATE_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_PARTICIPATE_BONUS) }}"
            id="{{ BonusConfig::TYPE_PARTICIPATE_BONUS }}"
            name="{{ BonusConfig::TYPE_PARTICIPATE_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_PARTICIPATE_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_NEW_MEMBER_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_NEW_MEMBER_BONUS) }}"
            id="{{ BonusConfig::TYPE_NEW_MEMBER_BONUS }}"
            name="{{ BonusConfig::TYPE_NEW_MEMBER_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_NEW_MEMBER_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_ATTENDANCE_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_ATTENDANCE_BONUS) }}"
            id="{{ BonusConfig::TYPE_ATTENDANCE_BONUS }}"
            name="{{ BonusConfig::TYPE_ATTENDANCE_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_ATTENDANCE_BONUS]) }}"
        />
    </td>
</tr>


<tr>
    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_REFERRAL_1_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_REFERRAL_1_BONUS) }}"
            id="{{ BonusConfig::TYPE_REFERRAL_1_BONUS }}"
            name="{{ BonusConfig::TYPE_REFERRAL_1_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_REFERRAL_1_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_REFERRAL_2_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_REFERRAL_2_BONUS) }}"
            id="{{ BonusConfig::TYPE_REFERRAL_2_BONUS }}"
            name="{{ BonusConfig::TYPE_REFERRAL_2_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_REFERRAL_2_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_HALL_OF_FAME_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_HALL_OF_FAME_BONUS) }}"
            id="{{ BonusConfig::TYPE_HALL_OF_FAME_BONUS }}"
            name="{{ BonusConfig::TYPE_HALL_OF_FAME_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_HALL_OF_FAME_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS) }}"
            id="{{ BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS }}"
            name="{{ BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_CONSOLATION_PRIZE_BONUS]) }}"
        />
    </td>
</tr>

<tr>
    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_PAYBACK_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_PAYBACK_BONUS) }}"
            id="{{ BonusConfig::TYPE_PAYBACK_BONUS }}"
            name="{{ BonusConfig::TYPE_PAYBACK_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_PAYBACK_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_ROLLING_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_ROLLING_BONUS) }}"
            id="{{ BonusConfig::TYPE_ROLLING_BONUS }}"
            name="{{ BonusConfig::TYPE_ROLLING_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_ROLLING_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_LOSING_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_LOSING_BONUS) }}"
            id="{{ BonusConfig::TYPE_LOSING_BONUS }}"
            name="{{ BonusConfig::TYPE_LOSING_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_LOSING_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_COUPON_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_COUPON_BONUS) }}"
            id="{{ BonusConfig::TYPE_COUPON_BONUS }}"
            name="{{ BonusConfig::TYPE_COUPON_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_COUPON_BONUS]) }}"
        />
    </td>
</tr>

<tr>
    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_SUDDEN_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_SUDDEN_BONUS) }}"
            id="{{ BonusConfig::TYPE_SUDDEN_BONUS }}"
            name="{{ BonusConfig::TYPE_SUDDEN_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_SUDDEN_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_PARTNER_SHARE_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_PARTNER_SHARE_BONUS) }}"
            id="{{ BonusConfig::TYPE_PARTNER_SHARE_BONUS }}"
            name="{{ BonusConfig::TYPE_PARTNER_SHARE_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_PARTNER_SHARE_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_MONTHLY_ATTENDANCE_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_MONTHLY_ATTENDANCE_BONUS) }}"
            id="{{ BonusConfig::TYPE_MONTHLY_ATTENDANCE_BONUS }}"
            name="{{ BonusConfig::TYPE_MONTHLY_ATTENDANCE_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_MONTHLY_ATTENDANCE_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_ADMIN_RECHARGE] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_ADMIN_RECHARGE) }}"
            id="{{ BonusConfig::TYPE_ADMIN_RECHARGE }}"
            name="{{ BonusConfig::TYPE_ADMIN_RECHARGE }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_ADMIN_RECHARGE]) }}"
        />
    </td>
</tr>

<tr>
    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_REFERRAL_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_REFERRAL_BONUS) }}"
            id="{{ BonusConfig::TYPE_REFERRAL_BONUS }}"
            name="{{ BonusConfig::TYPE_REFERRAL_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_REFERRAL_BONUS]) }}"
        />
    </td>

    <td style="width: 17%" class="text-center bg-black-darker6">{{ BonusConfig::LIST_EVENT_RESTRICTIONS[BonusConfig::TYPE_LEVEL_UP_BONUS] }}</td>
    <td style="width: 8%" class="text-center bg-black-darker p-5">
        <x-common.toggle_switch_button
            isCheck="{{ data_get($config, BonusConfig::TYPE_LEVEL_UP_BONUS) }}"
            id="{{ BonusConfig::TYPE_LEVEL_UP_BONUS }}"
            name="{{ BonusConfig::TYPE_LEVEL_UP_BONUS }}"
            urlAction="{{ route('admin.member-config.update-mc-event-restrictions-item', ['mID' => $mID, 'field' => BonusConfig::TYPE_LEVEL_UP_BONUS]) }}"
        />
    </td>
</tr>
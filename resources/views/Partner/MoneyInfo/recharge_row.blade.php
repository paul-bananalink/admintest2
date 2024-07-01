<tr>
    <td>{{ data_get($moneyInfo->member, 'partner.pName', '') }}</td>
    <td>
        LV <span class="text-green-1">{{ data_get($moneyInfo->member, 'mLevel') }}</span>
    </td>
    <td>
        <i class="fa fa-cog config-icon"></i>
        {{ $moneyInfo->member->mID ?? '' }}({{ $moneyInfo->member->mNick ?? '' }})
    </td>

    <td>
        <span class="text-blue-6">
            {{ formatNumber(data_get($moneyInfo->member, 'sum_deposit', 0)) }}
        </span>
        <span>({{ data_get($moneyInfo->member, 'count_deposit', 0) }})</span>
    </td>
    <td>
        <span class="text-pink-1">
            {{ formatNumber(data_get($moneyInfo->member, 'sum_withdraw', 0)) }}
        </span>
        <span>
            ({{ data_get($moneyInfo->member, 'count_withdraw', 0) }})
        </span>
    </td>
    <td>
        <span class="text-blue-6">{{ formatNumber(data_get($moneyInfo->member, 'totalProfit', 0)) }}원</span>
    </td>

    <td>
        <span class="text-blue-6">{{ formatNumber(data_get($moneyInfo, 'miBankMoney')) }}</span>
    </td>
    <td>
        {{ data_get($moneyInfo, 'miRegDate') }}
    </td>
    <td>
        {{ data_get($moneyInfo, 'miRegDate') }}
    </td>
    <td>
        {{ $moneyInfo->miStatus }}
    </td>
</tr>

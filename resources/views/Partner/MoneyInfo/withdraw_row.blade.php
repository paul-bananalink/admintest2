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
        <strong>
            <font size="4" color="#cc0066" class="m-r-8">{{ formatNumber($moneyInfo->miBankMoney) }}</font>
        </strong>
    </td>


    <td>
        {{ data_get($moneyInfo, 'miRegDate') }}
    </td>
    <td>
        {{ data_get($moneyInfo, 'mProcessDate') }}
    </td>
    <td>{{ $moneyInfo->miStatus }}</td>

</tr>

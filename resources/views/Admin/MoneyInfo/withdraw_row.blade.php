<tr>
    <td>{{ data_get($moneyInfo->member, 'partner.mPartnerName', '') }}</td>
    <td>
        LV <span class="text-green-1">{{ data_get($moneyInfo->member, 'mLevel') }}</span>
    </td>
    <td>
        <i class="fa fa-cog config-icon" aria-hidden="true"></i>
        <x-common.row_info_money :member="$moneyInfo->member" 
        suffix="money-info-withdraw-{{ $moneyInfo->miNo }}" />
        ({{ $moneyInfo->member->mNick }})
    </td>
    <td>
        <span class="text-green-2">
            {{ formatNumber(data_get($moneyInfo->member, 'mMoney', 0) + data_get($moneyInfo->member, 'mSportsMoney', 0)) }}
        </span>
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
        {{ data_get($moneyInfo, 'miBankName') }}
    </td>
    <td>
        {{ data_get($moneyInfo, 'miBankNumber') }}
    </td>
    <td>
        {{ data_get($moneyInfo, 'miBankOwner') }}
    </td>
    <td>
        <strong>
            <font size="4" color="#cc0066" class="m-r-8">{{ formatNumber($moneyInfo->miBankMoney) }}</font>
        </strong>
    </td>
    <td>
        <input type="checkbox" class="checkbox-withdraw" name="checkbox[miNo][]"
            value="{{ data_get($moneyInfo, 'miNo') }}" @disabled($moneyInfo->getRawOriginal('miStatus') != \App\Models\MoneyInfo::STATUS_ONE)>
    </td>

    <td>
        {{ data_get($moneyInfo, 'miRegDate') }}
    </td>
    <td>
        {{ data_get($moneyInfo, 'mProcessDate') }}
    </td>
    @if ($showActions)
        @php
            $status = $moneyInfo->getRawOriginal('miStatus');
        @endphp
        <td>
            @if ($status == 1)
                <button
                    data-route="{{ env('APP_URL') . '/admin/money-info/' . $type . '/update/' . data_get($moneyInfo, 'miNo') }}"
                    data-data="9" data-method="post" type="submit"
                    class="btnstyle1 btnstyle1-primary h-31 confirm-box"><strong>승인</strong></button>
                <button
                    data-route="{{ env('APP_URL') . '/admin/money-info/' . $type . '/update/' . data_get($moneyInfo, 'miNo') }}"
                    data-method="post" data-data="3" type="submit"
                    class="btnstyle1 btnstyle1-danger h-31 confirm-box"><strong>취소</strong></button>
            @elseif ($status == 9)
                <span class="text-blue-1"><i class="fa fa-check mr-4"></i> 쳐리완료</span>
            @elseif ($status == 3)
                <span class="text-danger"><i class="fa fa-close mr-4"></i> 취소처리</span>
            @endif
        </td>
        <td>
            <button id="btn_open_4640" type="button" data-toggle="collapse"
                data-target="#MEMBER_DETAIL{{ $moneyInfo->member->mNo }}-money-info-withdraw-{{$moneyInfo->miNo}}"
                class="btnstyle1 btnstyle1-primary btnstyle1-xs text-white">
                <i class="fa ion-android-add-circle text-gray f-s-20 m-t-2"></i>
            </button>
        </td>
    @endif
</tr>

<tr class="m-0 p-0 height-0">
    <td colspan="16" class="m-0 p-0 bg-black-lighter">
        <div id="MEMBER_DETAIL{{ $moneyInfo->member->mNo }}-money-info-withdraw-{{$moneyInfo->miNo}}" class="collapse width-full member-detail"
            data-url="{{ convertApiDomainToAppDomain(route('admin.status-members.detail', ['id' => data_get($moneyInfo->member, 'mNo')])) }}">
        </div>
    </td>
</tr>

<tr>
    <td>{{ data_get($moneyInfo->member, 'partner.mPartnerName', '') }}</td>
    <td>
        LV <span class="text-green-1">{{ data_get($moneyInfo->member, 'mLevel') }}</span>
    </td>
    <td>
        <i class="fa fa-cog config-icon" aria-hidden="true"></i>
        <x-common.row_info_money :member="$moneyInfo->member" suffix="money-info-recharge-{{ $moneyInfo->miNo }}" />
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
        {{ data_get($moneyInfo, 'miBankOwner') }}
    </td>
    <td>
        <span class="text-blue-6">{{ formatNumber(data_get($moneyInfo, 'miBankMoney')) }}</span>
    </td>
    <td>
        보너 스없음
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
            @elseif ($status == 2)
                <span class="text-warning"><i class="fa fa-warning mr-4"></i>
                    취소처리({{ $moneyInfo->process_member->mID }})</span>
            @elseif ($status == 3)
                <span class="text-danger"><i class="fa fa-close mr-4"></i> 환수처리
                </span>
            @endif
        </td>
        <td>
            <button id="btn_open_4640" type="button" data-toggle="collapse"
                data-target="#MEMBER_DETAIL{{ $moneyInfo->member->mNo }}-money-info-recharge-{{ $moneyInfo->miNo }}"
                class="btnstyle1 btnstyle1-primary btnstyle1-xs text-white">
                <i class="fa ion-android-add-circle text-gray f-s-20 m-t-2"></i>
            </button>
        </td>
        @if (isset($is_rollback_mode) && $is_rollback_mode)
            <td>
                <button
                    data-route="{{ env('APP_URL') . '/admin/money-info/' . $type . '/update/' . data_get($moneyInfo, 'miNo') }}"
                    data-method="post" data-data="2" type="submit"
                    class="btnstyle1 btnstyle1-warning h-31 confirm-box"><strong>환수처리(롤백)</strong></button>
            </td>
        @endif
    @endif
</tr>
<tr class="m-0 p-0 height-0">
    <td colspan="16" class="m-0 p-0 bg-black-lighter">
        <div id="MEMBER_DETAIL{{ $moneyInfo->member->mNo }}-money-info-recharge-{{ $moneyInfo->miNo }}"
            class="collapse width-full member-detail"
            data-url="{{ convertApiDomainToAppDomain(route('admin.status-members.detail', ['id' => data_get($moneyInfo->member, 'mNo')])) }}">
        </div>
    </td>
</tr>

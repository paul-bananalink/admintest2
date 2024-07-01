@use('App\Models\Member')

<tr class="member-row-{{ $member->mNo }} member-row-info-{{ $member->mNo }} @if ($member->mStatus != Member::M_STATUS_NINE) alpha-40 @endif"
    attr-mid="{{ $member->mID }}">
    <td class="bg-black-darker">{{ $index + 1 }}</td>
    <td class="bg-black-darker width-25 p-5">
        <span
            class="label f-s-12 p-5 label-{{ data_get($member, 'status_badge_type') }}"
            id="mStatusText{{ $member->mNo }}">{{ data_get($member, 'status_kr_text') }}</span>
    </td>
    <td class="bg-black-darker" style="color: rgb(255, 255, 255)">
        <strong>{{ $member->partner->pName ?? '' }}</strong>
    </td>
    <td class="bg-black-darker p-0">
        {{ data_get($member, 'mRegDate') }}
    </td>
    <td class="bg-black-darker">{{ data_get($member, 'mLoginDateTime') }}</td>
    <td class="bg-black-darker">LV <span style="color: #66ff66" class="mLevel">
            {{ data_get($member, 'mLevel', 1) }}</span>
    </td>
    <td class="bg-black-darker">
        <div class="height-full width-20 pull-left"
            style="padding: 0px 25px 0px 0px; border-right: 1px solid rgb(81, 81, 81);">
            <i class="fa fa-gear text-blue cursor f-s-18"></i>
        </div>
        {{ data_get($member, 'mID') }}
    </td>
    <td class="bg-black-darker">{{ data_get($member, 'mNick') }}</td>
    <td class="bg-black-darker">{{ data_get($member, 'mRealName') }}</td>
    <td class="bg-black-darker">
        <span style="color: #0066ff">{{ formatNumber(data_get($member, 'sum_deposit', 0)) }}</span>
        ({{ data_get($member, 'count_deposit', 0) }})
    </td>
    <td class="bg-black-darker">
        <span style="color: #cc0066">{{ formatNumber(data_get($member, 'sum_withdraw', 0)) }}</span>
        ({{ data_get($member, 'count_withdraw', 0) }})
    </td>
    <td class="bg-black-darker" class="mRevenue" attr-mid="{{ $member->mID }}">
        @php $revenue = data_get($member, 'sum_deposit', 0) + data_get($member, 'sum_withdraw', 0) @endphp
        <span>
            <span style="color: #{{ $revenue > 0 ? '0066ff' : ($revenue < 0 ? 'cc0066' : 'ffffff') }}">
                {{ formatNumber($revenue) }}
            </span> 원
        </span>
    </td>
    <td class="bg-black-darker">
        <span class="el-tooltip" aria-describedby="el-tooltip-2014"
            tabindex="0">{{ formatNumber(data_get($member, 'mSportsMoney', 0) + data_get($member, 'mMoney', 0)) }}</span>&nbsp;원
    </td>
    <td class="bg-black-darker">
        <span class="el-tooltip" aria-describedby="el-tooltip-2014"
            tabindex="0">{{ formatNumber(data_get($member, 'mPoint', 0)) }}</span>&nbsp;
    </td>
    <td class="bg-black-darker">
        <button type="button" class="btnstyle1 btnstyle1-success btnstyle1-sm height-31 pull-left m-r-10"
            style="width: calc(50% - 5px);">지급</button>
        <button type="button" class="btnstyle1 btnstyle1-success btnstyle1-sm height-31 pull-left"
            style="width: calc(50% - 5px);">내역</button>
    </td>
    <td class="bg-black-darker table-td-valign-top text-left p-3">
        <span class="text-red f-s-12 text-left p-0 m-0">{!! nl2br(data_get($member, 'mNote')) !!}</span>
    </td>
    {{-- <td class="bg-black-darker width-40">
        <x-common.toggle_switch_button isCheck="{{ $member->mStatus == Member::M_STATUS_NINE }}"
            id="mStatusEnable{{ $member->mNo }}" name="mStatus" dataId="{{ $member->mNo }}"
            urlAction="{{ route('admin.status-members.update-status-member', ['id' => $member->mNo, 'type' => 'enable']) }}"
            offToggle="true" />
    </td> --}}
    {{-- <td class="bg-black-darker width-40">
        <button type="button" data-toggle="collapse" data-target="#MEMBER_DETAIL{{ $member->mNo }}"
            class="btnstyle1 btnstyle1-primary btnstyle1-xs text-white">
            <i class="fa ion-android-add-circle text-gray f-s-20 m-t-2"></i>
        </button>
    </td> --}}
</tr>
@if ($includeDetail)
    <tr class="m-0 p-0 height-0 member-row-{{ $member->mNo }} @if ($member->mStatus != Member::M_STATUS_NINE) alpha-40 @endif">
        <td colspan="16" class="m-0 p-0 bg-black-lighter">
            <div id="MEMBER_DETAIL{{ $member->mNo }}" class="collapse width-full member-detail"
                data-url="{{ convertApiDomainToAppDomain(route('admin.status-members.detail', ['id' => data_get($member, 'mNo')])) }}">
            </div>
        </td>
    </tr>
@endif

<tr attr-mid="{{$member->mID}}">
    <td>
        {{data_get($member, 'status_text')}}
    </td>
    <td>
        {{ $member->partner->pName ?? '' }}
    </td>
    <td>
        {{ data_get($member, 'mRegDate') }}<br>{{ data_get($member, 'mApproveRegDate') }}
    </td>
    <td>
        {{ data_get($member, 'mLoginDateTime') }}
    </td>
    <td class="text-center">
        LV <span class="mLevel">{{ data_get($member, 'mLevel', 1) }}</span>
    </td>
    <td>
        <x-common.row_info_money :member="$member" />
    </td>
    <td class="mNick">
        {{ data_get($member, 'mNick') }}
    </td>
    <td>
        {{ data_get($member, 'mMemberID') }}
    </td>
    <td>
        {{ formatNumber(data_get($member, 'sum_deposit', 0)) }} /
        {{ data_get($member, 'count_deposit', 0) }}
    </td>
    <td>
        {{ formatNumber(data_get($member, 'sum_withdraw', 0)) }} /
        {{ data_get($member, 'count_withdraw', 0) }}
    </td>
    <td class="mRevenue" attr-mid="{{data_get($member, 'mID')}}">
        {{ formatNumber(data_get($member, 'sum_deposit', 0) + data_get($member, 'sum_withdraw', 0)) }}
    </td>
    <td class="mSportsMoney" attr-mid="{{data_get($member, 'mID')}}">
        {{ formatNumber(data_get($member, 'mSportsMoney', 0)) }}
    </td>
    <td class="mMoney" attr-mid="{{data_get($member, 'mID')}}">
        {{ formatNumber(data_get($member, 'mMoney', 0)) }}
    </td>
    <td>
        {!! data_get($member, 'mNote') !!}
    </td>
    <td>
        @if (data_get($member, 'mStatus') != \App\Models\Member::M_STATUS_NINE && empty(data_get($member, 'mApproveRegDate')))
            <a href="{{ convertApiDomainToAppDomain(route('admin.status-members.status-member-normal', ['id' => data_get($member, 'mNo'), ...request()->query()])) }}"
                class="show-tooltip btn btn-circle btn-success"
                data-original-title="대기">
                <i class="fa fa-check"></i>
            </a>
        @elseif (data_get($member, 'mStatus') != \App\Models\Member::M_STATUS_NINE && ! empty(data_get($member, 'mApproveRegDate')))
            <a href="{{ convertApiDomainToAppDomain(route('admin.status-members.status-member-normal', ['id' => data_get($member, 'mNo'), ...request()->query()])) }}"
                class="show-tooltip btn btn-circle btn-info"
                data-original-title="대기">
                <i class="fa fa-play"></i>
            </a>
        @else
            <a href="{{ convertApiDomainToAppDomain(route('admin.status-members.status-member-stop', ['id' => data_get($member, 'mNo'), ...request()->query()])) }}"
                class="show-tooltip btn btn-circle btn-danger"
                data-original-title="정지">
                <i class="fa fa-stop"></i>
            </a>
        @endif
    </td>
    <td>
        <button
            data-url="{{ convertApiDomainToAppDomain(route('admin.status-members.info', ['id' => data_get($member, 'mNo')])) }}"
            class="btn btn-circle btn-primary open-modal-member-config"
            data-target="#modalMemberConfig" data-toggle="modal">
            <i class="fa fa-gear" style="font-size: 1em;"
                aria-hidden="true"></i>
        </button>
    </td>
</tr>

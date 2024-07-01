@isset($member)
    <a class="text-light item-transfer" data-placement="right" data-html="true" data-toggle="tooltip" data-trigger="manual"
        data-mID="{{ data_get($member, 'mID') }}" data-mmoney="{{ data_get($member, 'mMoney', 0) }}"
        data-msportsmoney="{{ data_get($member, 'mSportsMoney', 0) }}"
        data-note-route="{{ route('admin.note.viewCreateNoteSendUser', ['mNo' => data_get($member, 'mNo')]) }}"
        data-edit-route="{{ route('admin.status-members.update-member', ['id' => data_get($member, 'mNo')]) }}"
        data-lock-note-route="{{ data_get($member, 'mStatus') != \App\Models\Member::M_STATUS_NINE }}"
        data-open-window-note-route="1"
        data-direct-recharge-or-withdraw="{{ route('admin.money-info.direct-recharge-or-withdraw', ['mID' => data_get($member, 'mID')]) }}"
        data-mno="{{ data_get($member, 'mNo') }}" href="#"
        
        data-target="#MEMBER_DETAIL{{ $member->mNo }}-{{ $suffix ?? '' }}"
        data-recharge-histories="{{ route('admin.money-info.index', ['mID' => data_get($member, 'mID'), 'type' => 'recharge']) }}"
        data-withdraw-histories="{{ route('admin.money-info.index', ['mID' => data_get($member, 'mID'), 'type' => 'withdraw']) }}"
        data-betting-details="{{ route('admin.betting-histories.casino', ['search_input' => data_get($member, 'mID')]) }}"
        data-bonus-details="{{ route('admin.point-history.index', ['search' => data_get($member, 'mID')]) }}"
        data-cash-details="{{ route('admin.cash.index', ['search' => data_get($member, 'mID')]) }}"
        >
        {{ data_get($member, 'mID') }}
    </a>
@endisset

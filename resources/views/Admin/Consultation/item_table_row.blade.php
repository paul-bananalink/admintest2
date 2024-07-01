<tr>
    <td>{{ $consultation->member->partner->pName ?? '' }}</td>
    <td>LV <span class="text-green-1">{{ $consultation->member->mLevel }}</span></td>
    <td>
        <div class="px-8">
            <i class="fa fa-cog config-icon" aria-hidden="true"></i> {{ $consultation->member->mID }}
            ({{ $consultation->member->mNick }})
        </div>
    </td>
    <td><span class="text-green-3">{{ formatNumber($consultation->member->totalMoney()) }}원</span></td>
    <td><span
            class="text-blue-6 mr-3">{{ formatNumber($consultation->member->sum_deposit) }}</span>원({{ $consultation->member->count_deposit ?: 0 }})
    </td>
    <td><span
            class="text-red-4 mr-3">{{ formatNumber($consultation->member->sum_withdraw) }}</span>원({{ $consultation->member->count_withdraw ?: 0 }})
    </td>
    <td><span class="text-blue-3">{{ formatNumber($consultation->member->total_profit) }}</span> 원</td>
    <td>
        <div>{{ $consultation->created_at }}</div>
        <div>{{ $consultation->date_feedback }}</div>
    </td>
    <td style="text-align: inherit">
        <div>{{ $consultation->content }}</div>
        <div class="content-reply-all show-hide-content-{{ $consultation->id }}">
            {!! $consultation->getHtmlReplied() !!}
        </div>
        <div class="default-reply reply-content-{{ $consultation->id }}"></div>
    </td>
    <td><a href="#" class="btnstyle1 btnstyle1-danger h-31 px-8 confirm-box"
            data-route="{{ route('admin.consultation.delete', ['id' => $consultation->id]) }}" data-method="delete"><i
                class="fa fa-trash" aria-hidden="true"></i></a></td>
    <td>
        <button type="button" data-toggle="collapse"
            data-target="#MEMBER_DETAIL{{ $consultation->member->mNo }}-consultation-{{ $consultation->id }}"
            class="btnstyle1 btnstyle1-primary btnstyle1-xs text-white">
            <i class="fa ion-android-add-circle f-s-20 m-t-2"></i>
        </button>
    </td>
    @if (!$consultation->date_feedback)
        <td style="width: 80px"><span href="#" class="btnstyle1 btnstyle1-danger h-31 px-8 reply-cons"
                data-item-id="{{ $consultation->id }}" data-open-reply="{{ 1 }}">답변달기</span>
        </td>
    @else
        <td style="width: 80px"><span href="#" class="btnstyle1 btnstyle1-primary h-31 px-8 reply-cons"
                data-item-id="{{ $consultation->id }}" data-open-reply="{{ 1 }}">답변 수정</span>
        </td>
    @endif
    <td></td>
</tr>
<tr class="m-0 p-0 height-0">
    <td colspan="16" class="m-0 p-0 bg-black-lighter">
        <div id="MEMBER_DETAIL{{ $consultation->member->mNo }}-consultation-{{ $consultation->id }}"
            class="collapse width-full member-detail"
            data-url="{{ convertApiDomainToAppDomain(route('admin.status-members.detail', ['id' => data_get($consultation->member, 'mNo')])) }}">
        </div>
    </td>
</tr>

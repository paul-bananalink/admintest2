<li>
    <div>
        <a href="{{ route('admin.status-members.index', ['select_field_search' => 'm_partner', 'search' => $item->mID, 'btn_submit' => 'click']) }}">
            {{ $item->mID }} {{ $item->member ? '('.$item->pName.')': '' }} {{ $item->member && $item->member->mMemberID ? '('.$item->member->mMemberID.')': '' }}
        </a>
    </div>

    @if ($item->childs)
        <ul>
            @foreach ($item->childs as $child)
                @include('Admin.MemberPartner.child_view', ['item' => $child])
            @endforeach
        </ul>
    @endif
</li>

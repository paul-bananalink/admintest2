<li>
    <div>{{ $item->mID }} {{ $item->member ? '('.$item->member->mNick.')': '' }} {{ $item->member && $item->member->mMemberID ? '('.$item->member->mMemberID.')': '' }}</div>
    @if ($item->childs)
        <ul>
            @foreach ($item->childs as $child)
                @include('Partner.Manager.child_view', ['item' => $child])
            @endforeach
        </ul>
    @endif
</li>

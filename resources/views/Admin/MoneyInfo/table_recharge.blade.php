<table id="{{ $type . 'Table' }}" data-name="{{ $type }}" class="table table-bordered cst-table-darkbrown">
    <thead>
        <tr>
            <th>파트너명</th> {{-- partne name --}}
            <th>레벨</th> {{-- level --}}
            <th>아이디 (넉네임)</th> {{-- id(nickname) --}}
            <th>보유머니</th> {{-- available amount --}}
            <th>입금수</th> {{-- rechange --}}
            <th>출금수</th> {{-- withdraw --}}
            <th>수익(입금-출금)</th> {{-- profit --}}
            <th>예금주</th> {{-- bank owner --}}
            <th>입금신청 금액</th> {{-- money request rechange --}}
            <th>보너스명</th> {{-- bank bonus --}}
            <th>신청 시간</th> {{-- time register order --}}
            <th>처리시간</th> {{-- time proccess order --}}
            <th>처리상태</th> {{-- time proccess order --}}
            <th>세부</th> {{-- function --}}
            @if ($is_rollback_mode)
                <th>환수</th> {{-- rollback --}}
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            @include('Admin.MoneyInfo.recharge_row', [
                'moneyInfo' => $item,
                'showActions' => true,
                'type' => $type,
                'is_rollback_mode' => $is_rollback_mode,
            ])
        @endforeach
    </tbody>
</table>

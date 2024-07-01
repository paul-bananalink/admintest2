<table id="{{ $type . 'Table' }}" data-name="{{ $type }}" class="table table-bordered cst-table-darkbrown">
    <thead>
        <tr>
            <th>파트너명</th>
            <th>레벨</th>
            <th>아이디 (닉네임)</th>
            <th>보유머니</th>
            <th>입금수</th>
            <th>출금수</th>
            <th>수익(입금-출금)</th>
            <th>은행</th>
            <th>계좌</th>
            <th>예금주</th>
            <th>출금신청금액</th>
            <th></th>
            <th>신청시간</th>
            <th>처리시간</th>
            <th>처리상태</th>
            <th>세부</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            @include('Admin.MoneyInfo.withdraw_row', [
                'moneyInfo' => $item,
                'showActions' => true,
                'type' => $type,
            ])
        @endforeach
    </tbody>
</table>

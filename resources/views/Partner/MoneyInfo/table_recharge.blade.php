{{-- <table id="{{ $type . 'Table' }}" data-name="{{ $type }}" class="table table-bordered cst-table-darkbrown"> --}}
<table data-name="{{ $type }}" class="table table-bordered cst-table-darkbrown">
    <thead>
        <tr>
            <th>파트너명</th>
            <th>레벨</th>
            <th>아이디 (닉네임)</th>
            <th>입금수</th>
            <th>출금수</th>
            <th>수익(입금-출금)</th>
            <th>입금신청금액</th>
            <th>신청시간</th>
            <th>처리시간</th>
            <th>처리상태</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            @include('Partner.MoneyInfo.recharge_row', [
                'moneyInfo' => $item,
            ])
        @endforeach
    </tbody>
</table>

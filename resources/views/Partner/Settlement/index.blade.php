@extends('Partner.Settlement.page')
@section('content-settlement')
    @include('Partner.Common.breadcrumb', ['title' => '정산'])
    <!-- BEGIN Main Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-content">

                    <table class="table table-bordered cst-table-darkbrown">
                        <thead>
                            <tr>
                                <th>파트너명</th>
                                <th>레벨</th>
                                <th>아이디 (닉네임)</th>
                                <th>이름</th>
                                <th style="width: 11%;" class="column-table-member">
                                    <div class="table-title">입금
                                        @include('Partner.Common.pair_button_arrow_sort', [
                                            'column' => 'sumDepositMoney',
                                        ])
                                    </div>
                                </th>
                                <th style="width: 11%;">
                                    <div class="table-title">출금
                                        @include('Partner.Common.pair_button_arrow_sort', [
                                            'column' => 'sumWithdrawMoney',
                                        ])
                                    </div>
                                </th>
                                <th style="width: 11%;">
                                    <div class="table-title">수익(입금-출금)
                                        @include('Partner.Common.pair_button_arrow_sort', [
                                            'column' => 'profit',
                                        ])
                                    </div>
                                </th>
                                <th style="width: 11%;">
                                    <div class="table-title">배팅(배팅)(취소)
                                        @include('Partner.Common.pair_button_arrow_sort', [
                                            'column' => 'sumBet',
                                        ])
                                    </div>
                                </th>
                                <th style="width: 11%;">
                                    <div class="table-title">당첨 (WIN)
                                        @include('Partner.Common.pair_button_arrow_sort', [
                                            'column' => 'sumBetWin',
                                        ])
                                    </div>
                                </th>
                                <th style="width: 8%;">
                                    <div class="table-title">승룰(배팅-당첨)
                                        @include('Partner.Common.pair_button_arrow_sort', [
                                            'column' => 'winningRate',
                                        ])
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        {{ $item->partner->pName ?? '' }}
                                    </td>
                                    <td>{{ $item->mLevelToString() }}</td>
                                    <td>{{ $item->mID }}</td>
                                    <td>{{ $item->mNick }}</td>
                                    <td>{{ formatNumber($item->sumDepositMoney) }}</td>
                                    <td>{{ formatNumber($item->sumWithdrawMoney) }}</td>
                                    <td>{{ formatNumber($item->profit) }}</td>
                                    <td>{{ formatNumber($item->sumBet) }}</td>
                                    <td>{{ formatNumber($item->sumBetWin) }}</td>
                                    <td>{{ $item->winningRate ? $item->winningRate . ' %' : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        @if ($data)
                            {{ $data->appends(request()->query())->links('Partner.Common.pagination') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Main Content -->
@endsection

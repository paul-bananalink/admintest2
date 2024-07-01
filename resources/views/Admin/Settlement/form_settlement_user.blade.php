@extends('Admin.Settlement.page')

@section('content-child')
    <div class="panel-heading-page flex pb-10 bottom-solid-black space-between">
        <h4 class="panel-title m-5 flex-1">
            <strong>
                <i class="fa fa-arrow-down"></i> CALC LIST :: 유저별 일일 정산관리
            </strong>
        </h4>
        <div class="panel-heading-btn">
            <form action="{{ route('admin.settlement.user') }}" method="get">
                <span class="text-white">아이디:</span>
                <div class="btn-group">
                    <input placeholder="아이디를" type="text" autocomplete="off" id="mID" name="mID"
                        class="form-control input-sm width-200 search-input-box height-33 p-l-5 text-white"
                        style="float: left" value="{{ request('mID') }}" />
                </div>
                <div class="btn-group">
                    <div class="input-daterange">
                        <div class="el-date-editor el-range-editor el-input__inner">
                            <i class="fa fa-calendar"></i>
                            <input autocomplete="off" placeholder="날짜 검색" name="date_search" class="el-input"
                                value="{{ request('date_search') }}" id="js__single-date-cash" />
                        </div>
                    </div>
                </div>
                <div class="btn-group">
                    <button class="btnstyle1 btnstyle1-inverse3 btnstyle1-sm height-33 m-r-15 m-l-5" style="float: left"
                        type="submit">
                        검색
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="animated fadeInUp panel panel-inverse bg-black-darker2 m-t-10 p-0">
        <div class="no-bg m-t-10">
            <table id="RegMemberTable" class="table table-bordered table-td-valign-middle text-center text-white no-bg">
                <thead>
                    <tr>
                        <td class="text-center bg-black-darker6">파트너명</td>
                        <td class="text-center bg-black-darker6">레벨</td>
                        <td class="text-center bg-black-darker6">아이디 (닉네임)</td>
                        <td class="text-center bg-black-darker6">이름</td>
                        <td class="text-center bg-black-darker6">
                            입금
                            @include('Admin.Common.pair_button_arrow_sort_new', [
                                'column' => 'sumDepositMoney',
                            ])
                        </td>
                        <td class="text-center bg-black-darker6 width-300">
                            출금
                            @include('Admin.Common.pair_button_arrow_sort_new', [
                                'column' => 'sumWithdrawMoney',
                            ])
                        </td>
                        <td class="text-center bg-black-darker6">
                            수익(입-출)
                            @include('Admin.Common.pair_button_arrow_sort_new', [
                                'column' => 'profit',
                            ])
                        </td>
                        <td class="text-center bg-black-darker6">
                            배팅&배팅취소
                            @include('Admin.Common.pair_button_arrow_sort_new', [
                                'column' => 'sumTransBet',
                            ])
                        </td>
                        <td class="text-center bg-black-darker6">
                            당첨
                            @include('Admin.Common.pair_button_arrow_sort_new', [
                                'column' => 'sumTransBetWin',
                            ])
                        </td>
                        <td class="text-center bg-black-darker6">
                            승룰(배-당)
                            @include('Admin.Common.pair_button_arrow_sort_new', [
                                'column' => 'winningRate',
                            ])
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td class="bg-black-darker" style="color: rgb(255, 255, 255)">
                                <strong>{{ $item->partner->pName ?? '' }}</strong>
                            </td>
                            <td class="bg-black-darker">{{ $item->mLevel }}</td>
                            <td class="bg-black-darker">
                                <div class="height-full width-20 pull-left"
                                    style="padding: 0px 25px 0px 0px; border-right: 1px solid rgb(81, 81, 81);">
                                    <i class="fa fa-gear text-blue cursor f-s-18"></i>
                                </div>
                                {{ data_get($item, 'mID') }}
                            </td>
                            <td class="bg-black-darker">{{ data_get($item, 'mNick') }}</td>
                            <td class="bg-black-darker">
                                <span style="color: #0066ff">{{ formatNumber($item->sumDepositMoney) }}</span>
                                (0)
                            </td>
                            <td class="bg-black-darker">
                                <span style="color: #cc0066">{{ formatNumber($item->sumWithdrawMoney) }}</span>
                                (0)
                            </td>
                            <td class="bg-black-darker">
                                @php $profit = $item->profit @endphp
                                <span>
                                    <span
                                        style="color: #{{ $profit > 0 ? '0066ff' : ($profit < 0 ? 'cc0066' : 'ffffff') }}">
                                        {{ formatNumber($profit) }}
                                    </span> 원
                                </span>
                            </td>
                            <td class="bg-black-darker">
                                <span style="color: #0066ff">{{ formatNumber($item->sumTransBet) }}</span>
                                (0)
                            </td>
                            <td class="bg-black-darker">
                                <span style="color: #cc0066">{{ formatNumber($item->sumTransBetWin) }}</span>
                                (0)
                            </td>
                            <td class="bg-black-darker">
                                <span
                                    style="color: #cc0066">{{ $item->winningRate ? $item->winningRate . ' %' : '-' }}</span>
                                (0)
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="overunderline m-t-10"></div>
        @if ($data)
            <div class="text-center">
                {{ $data->appends(request()->query())->links('Admin.Common.pagination') }}
            </div>
        @endif
    </div>
@endsection

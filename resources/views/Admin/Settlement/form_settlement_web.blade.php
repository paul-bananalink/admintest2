@extends('Admin.Settlement.page')

@section('content-child')
    <div class="panel-heading-page flex pb-10 bottom-solid-black space-between">
        <h4 class="panel-title m-5 flex-1">
            <strong>
                <i class="fa fa-arrow-down"></i> CALC LIST :: 정산관리
            </strong>
        </h4>
        <div class="panel-heading-btn">
            <form action="{{ route('admin.settlement.web') }}" method="get">
                <span class="text-white">아이디:</span>
                <div class="btn-group">
                    <input placeholder="아이디를" type="text" autocomplete="off" id="mID" name="mID"
                        class="form-control input-sm width-200 search-input-box height-33 p-l-5 text-white"
                        style="float: left" value="{{ request('mID') }}" />
                </div>
                <div class="btn-group">
                    <select class="form-control input-sm search-input-box height-33 text-white width-full"
                        style="border: 1px solid rgb(17, 17, 17)" name="select_field_search" id="select_field_search">
                        <option value="" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91)" selected>
                            사이트전체
                        </option>
                    </select>
                </div>
                <div class="btn-group">
                    <div class="input-daterange">
                        <div class="el-date-editor el-range-editor el-input__inner el-date-editor--daterange">
                            <i class="fa fa-calendar"></i>
                            <input autocomplete="off" placeholder="검색시작날짜" name="start_date" class="el-range-input"
                                value="{{ request('start_date', '') }}" id="js__single-start-date" />
                            <span class="el-range-separator">To</span>
                            <input autocomplete="off" placeholder="검색마지막날짜" name="end_date" class="el-range-input"
                                value="{{ request('end_date', '') }}" id="js__single-end-date" />
                        </div>
                    </div>
                </div>
                <div class="btn-group">
                    <button class="btnstyle1 btnstyle1-inverse3 btnstyle1-sm height-33 m-r-15 m-l-5" style="float: left"
                        type="submit">
                        검색
                    </button>
                </div>
                <div class="btn-group">
                    <x-common.toggle_switch_button content="ON" contentOff="하부미포함" isCheck="false" size="big"
                        width="100px" />
                </div>
            </form>
        </div>
    </div>
    <div class="animated fadeInUp panel panel-inverse bg-black-darker2 m-t-10 p-0">
        <div class="no-bg mt-20">
            <div class="text-center font-bold text-white f-s-16 mb-10">
                <span class="text-warning">회원보유액:</span>
                <span class="text-blue-1">0</span> 원
            </div>
            <div class="text-white mb-10">※ 관리자/파트너/가입코드(테스트) 회원은 정산에 포함되지 않습니다.</div>
            <table class="table table-bordered table-td-valign-middle text-center text-white no-bg">
                <thead>
                    <tr>
                        <td class="text-center bg-black-darker6">날짜</td>
                        <td class="text-center bg-black-darker6">회원 가입</td>
                        <td class="text-center bg-black-darker6">입금</td>
                        <td class="text-center bg-black-darker6">출금</td>
                        <td class="text-center bg-black-darker6">수익(입-출)</td>
                        <td class="text-center bg-black-darker6">파트너출금</td>
                        <td class="text-center bg-black-darker6">지급캐쉬</td>
                        <td class="text-center bg-black-darker6">지급포인트</td>
                        <td class="text-center bg-black-darker6">
                            사용한 쿠폰금액(수량) <i class="fa fa-info"></i>
                        </td>
                        <td class="text-center bg-black-darker6">지인정산</td>
                        <td class="text-center bg-black-darker6">배팅&배팅취소</td>
                        <td class="text-center bg-black-darker6">당첨</td>
                        <td class="text-center bg-black-darker6">승률(배-당)</td>
                        <td class="text-center bg-black-darker6">수동당첨금액</td>
                        <td class="text-center bg-black-darker6">상세</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $item)
                        <tr>
                            <td class="bg-black-darker p-0" style="color: rgb(255, 255, 255)">
                                {{ $item['date'] }}
                            </td>
                            <td class="bg-black-darker">
                                {{-- <span class="text-warning"> 0 </span> --}}
                            </td>
                            <td class="bg-black-darker">
                                <span style="color: #0066ff; font-weight: bold;"> {{ formatNumber($item['sumDepositMoney']) }} </span>
                                {{-- <span class="text-gray">(0/0)</span> --}}
                            </td>
                            <td class="bg-black-darker">
                                <span style="color: #cc0066; font-weight: bold;"> {{ formatNumber($item['sumWithdrawMoney']) }} </span>
                                {{-- <span class="text-gray">(0/0)</span> --}}
                            </td>
                            <td class="bg-black-darker">
                                @php $profit = $item['profit'] @endphp
                                <span>
                                    <span
                                        style="color: #{{ $profit > 0 ? '0066ff' : ($profit < 0 ? 'cc0066' : 'ffffff') }}">
                                        {{ formatNumber($profit) }}
                                    </span>
                                </span>
                                {{-- <span class="text-gray">(0)</span> --}}
                            </td>
                            <td class="bg-black-darker">
                                {{-- <span style="color: #cc0066; font-weight: bold;"> 0 </span> --}}
                            </td>
                            <td class="bg-black-darker">
                                {{-- <span style="color: #cc0066; font-weight: bold;"> 0 </span> --}}
                                {{-- <span class="text-gray">(0)</span> --}}
                            </td>
                            <td class="bg-black-darker">
                                {{-- <span style="color: #cc0066; font-weight: bold;"> 0 </span> --}}
                                {{-- <span class="text-gray">(0)</span> --}}
                            </td>
                            <td class="bg-black-darker">
                                {{-- <span style="color: #cc0066; font-weight: bold;"> 0 </span> --}}
                                {{-- <span class="text-gray">(0)</span> --}}
                            </td>
                            <td class="bg-black-darker">
                                {{-- <span style="color: #cc0066; font-weight: bold;"> 0 </span> --}}
                            </td>
                            <td class="bg-black-darker">
                                <span style="color: #0066ff; font-weight: bold;"> {{ formatNumber($item['sumTransBet']) }} </span>
                                {{-- <span class="text-gray">(0)</span> --}}
                                {{-- <span style="color: #cc0066">(0)</span> --}}
                            </td>
                            <td class="bg-black-darker">
                                <span style="color: #cc0066; font-weight: bold;"> {{ formatNumber($item['sumTransBetWin']) }} </span>
                                {{-- <span class="text-gray">(0)</span> --}}
                            </td>
                            <td class="bg-black-darker">
                                <span style="color: #0066ff; font-weight: bold;"> {{ formatNumber($item['winningRate']) }} </span>
                                {{-- <span class="text-gray">(0)</span> --}}
                                {{-- <span style="color: #cc0066">(0)</span> --}}
                            </td>
                            <td class="bg-black-darker">
                                {{-- <span style="color: #0066ff; font-weight: bold;"> 0 </span> --}}
                                {{-- <span class="text-gray">(0)</span> --}}
                            </td>
                            <td class="bg-black-darker">
                                <button type="button" data-toggle="collapse"
                                    data-target="#SETTLEMENT_WEB_DETAIL{{ $index }}"
                                    class="btnstyle1 btnstyle1-primary btnstyle1-xs text-white">
                                    <i class="fa fa-bar-chart f-s-20 m-t-2"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="m-0 p-0 height-0">
                            <td colspan="16" class="m-0 p-0 bg-dark">
                                <div id="SETTLEMENT_WEB_DETAIL{{ $index }}" class="collapse width-full settlement-web-detail"
                                    data-url="{{ route('admin.settlement.webDetail', ['row_date' => $item['date'], ...request()->query()]) }}"
                                    style="border: 3px solid #0066ff"></div>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="no-bg" style="height: 30px;"></tr>
                    <tr class="f-s-16">
                        <td class="bg-black-4" style="color: rgb(255, 255, 255)">
                            <span style="font-weight: bold">현재합계</span>
                        </td>
                        <td class="bg-black-4">
                            {{-- <span class="text-warning"> 0 </span> --}}
                        </td>
                        <td class="bg-black-4">
                            <span style="color: #0066ff; font-weight: bold;"> {{ formatNumber(array_sum(array_column($data, 'sumDepositMoney'))) }} </span>
                            {{-- <span class="text-gray">(0/0)</span> --}}
                        </td>
                        <td class="bg-black-4">
                            <span style="color: #cc0066; font-weight: bold;"> {{ formatNumber(array_sum(array_column($data, 'sumWithdrawMoney'))) }} </span>
                            {{-- <span class="text-gray">(0/0)</span> --}}
                        </td>
                        <td class="bg-black-4">
                            @php $profit = array_sum(array_column($data, 'profit')) @endphp
                            <span>
                                <span
                                    style="color: #{{ $profit > 0 ? '0066ff' : ($profit < 0 ? 'cc0066' : 'ffffff') }}">
                                    {{ formatNumber($profit) }}
                                </span>
                            </span>
                            {{-- <span class="text-gray">(0)</span> --}}
                        </td>
                        <td class="bg-black-4">
                            {{-- <span style="color: #cc0066; font-weight: bold;"> 0 </span> --}}
                        </td>
                        <td class="bg-black-4">
                            {{-- <span style="color: #cc0066; font-weight: bold;"> 0 </span> --}}
                            {{-- <span class="text-gray">(0)</span> --}}
                        </td>
                        <td class="bg-black-4">
                            {{-- <span style="color: #cc0066; font-weight: bold;"> 0</span> --}}
                            {{-- <span class="text-gray">(0)</span> --}}
                        </td>
                        <td class="bg-black-4">
                            {{-- <span style="color: #cc0066; font-weight: bold;"> 0 </span> --}}
                            {{-- <span class="text-gray">(0)</span> --}}
                        </td>
                        <td class="bg-black-4">
                            {{-- <span style="color: #cc0066; font-weight: bold;"> 0 </span> --}}
                        </td>
                        <td class="bg-black-4">
                            <span style="color: #0066ff; font-weight: bold;"> {{ formatNumber(array_sum(array_column($data, 'sumTransBet'))) }} </span>
                            {{-- <span class="text-gray">(0)</span> --}}
                            {{-- <span style="color: #cc0066">(0)</span> --}}
                        </td>
                        <td class="bg-black-4">
                            <span style="color: #cc0066; font-weight: bold;"> {{ formatNumber(array_sum(array_column($data, 'sumTransBetWin'))) }} </span>
                            {{-- <span class="text-gray">(0)</span> --}}
                        </td>
                        <td class="bg-black-4">
                            <span style="color: #0066ff; font-weight: bold;"> {{ formatNumber(array_sum(array_column($data, 'winningRate'))) }} </span>
                            {{-- <span class="text-gray">(0)</span> --}}
                            {{-- <span style="color: #cc0066">(0)</span> --}}
                        </td>
                        <td class="bg-black-4">
                            {{-- <span style="color: #0066ff; font-weight: bold;"> 0 </span> --}}
                            {{-- <span class="text-gray">(0)</span> --}}
                        </td>
                        <td class="bg-black-4">
                            <button type="button" data-toggle="collapse"
                                data-target="#SETTLEMENT_WEB_DETAIL_TOTAL"
                                class="btnstyle1 btnstyle1-success btnstyle1-xs text-white">
                                <i class="fa fa-bar-chart f-s-20 m-t-2"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="m-0 p-0 height-0">
                        <td colspan="16" class="m-0 p-0 bg-dark">
                            <div id="SETTLEMENT_WEB_DETAIL_TOTAL" class="collapse width-full settlement-web-detail"
                                data-url="{{ route('admin.settlement.webDetail', ['row_date' => null, ...request()->query()]) }}"
                                style="border: 3px solid #0066ff"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center font-bold text-white f-s-16 mb-10">
                <span class="text-warning">회원보유액:</span>
                <span class="text-blue-1">0</span> 원
            </div>
        </div>
        <div class="overunderline m-t-10"></div>
    </div>
@endsection

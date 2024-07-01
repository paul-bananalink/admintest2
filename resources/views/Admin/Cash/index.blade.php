@extends('Admin.Cash.page')

@section('content-cash')
    <x-common.panel_heading icon="fa fa-arrow-down" page="CASH DATA" title="캐쉬관리" form="Admin.Cash.cash_search_form" />
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-content">
                    <table id="moneyManagementTable" class="table table-bordered cst-table-darkbrown text-center">
                        <thead>
                            <tr>
                                <th style="text-align: center">파트너명</th>
                                <th style="text-align: center">레벨</th>
                                <th style="text-align: center">아이디 (닉네임)</th>
                                <th style="text-align: center">보유머니</th>
                                <th style="text-align: center">입금수</th>
                                <th style="text-align: center">출금수</th>
                                <th style="text-align: center">수익(입금-출금)</th>
                                <th style="text-align: center">처리내용</th>
                                <th style="text-align: center">캐쉬</th>
                                <th style="text-align:center">처리시간</th>
                                <th style="text-align: center">캐쉬타입</th>
                                <th style="text-align: center">캐쉬합</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $value)
                                @if (empty($value->item->member))
                                    @continue
                                @endif
                                @php
                                    $member = $value->item->member;
                                    $count_deposit = $member->count_deposit ?? 0;
                                    $total_deposit = $member->sum_deposit ?? 0;
                                    $count_withdraw = $member->count_withdraw ?? 0;
                                    $total_withdraw = $member->sum_withdraw ?? 0;
                                    $total_profit = $member->total_profit;
                                    $message = $value->message;
                                @endphp
                                <tr>
                                    <td>{{ $member->partner->mPartnerName ?? '' }}</td>
                                    <td>Lv.<span class="text-green-1">{{ $member->mLevel ?? '' }}</span></td>
                                    <td>
                                        <i class="fa fa-cog config-icon"></i>
                                        <x-common.row_info_money :member="$member" suffix="cash-{{ $value->item->miNo }}" />
                                        {{ $member->mNick ? '(' . $member->mNick . ')' : '' }}
                                    </td>
                                    <td>
                                        <span class="text-green-2">
                                            {{ formatNumber($member->total_money) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-blue-6">
                                            {{ formatNumber($total_deposit) }}
                                        </span>
                                        <span>({{ $count_deposit }})</span>
                                    </td>
                                    <td>
                                        <span class="text-pink-1">
                                            {{ formatNumber($total_withdraw) }}
                                        </span>
                                        <span>({{ $count_withdraw }})</span>
                                    </td>
                                    <td>
                                        <span class="text-blue-6">
                                            {{ formatNumber($total_profit) }}
                                        </span>
                                        원
                                    </td>
                                    <td>
                                        {!! $message !!}
                                    </td>
                                    <td>
                                        <strong>
                                            <font size="3"
                                                @if ($value->amount >= 0) color="#0066ff" @else color="#cc0066" @endif>
                                                <!---->
                                                {{ formatNumber($value->amount) }}
                                            </font>
                                        </strong>
                                    </td>
                                    <td>{{ $value->cRegDate }}</td>
                                    <td> {{ $value->type }} </td>
                                    <td>
                                        @php
                                            $money = $value->mMoney + $value->mSportsMoney;
                                            $classCash = $money >= 0 ? 'text-green-2' : '';
                                        @endphp
                                        <span class={{ $classCash }}>{{ formatNumber($money) }}</span>
                                    </td>
                                </tr>
                                <tr class="m-0 p-0 height-0">
                                    <td colspan="16" class="m-0 p-0 bg-black-lighter">
                                        <div id="MEMBER_DETAIL{{ $member->mNo }}-cash-{{ $value->item->miNo }}"
                                            class="collapse width-full member-detail"
                                            data-url="{{ convertApiDomainToAppDomain(route('admin.status-members.detail', ['id' => data_get($member, 'mNo')])) }}">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        @if ($data)
                            <div class="text-center">
                                {{ $data->appends(request()->query())->links('Admin.Common.pagination') }}
                            </div>
                        @endif
                    </div>
                    <x-common.panel_heading icon="" page="" title="캐쉬쳐리-관리자"
                        form="Admin.Cash.cash_payment_recovery_form" />
                </div>
            </div>
        </div>
    </div>
@endsection

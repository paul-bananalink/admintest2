@extends('Admin.PointHistory.page')

@section('point-history-money')
    <div class="panel-heading-page flex pb-10 bottom-solid-black space-between">
        <h4 class="panel-title m-5 flex-1">
            <strong>
                <i class="fa fa-arrow-down"></i> POINT HISTORY DATA :: 캐쉬관리
            </strong>
        </h4>
        @include('Admin.PointHistory.point_history_search_form_new')
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-content">
                    <table id="pointHistoryTable" class="table table-bordered cst-table-darkbrown text-center">
                        <thead>
                            <tr class="text-center">
                                <th>파트너명</th>
                                <th>레벨</th>
                                <th>아이디 (닉네임)</th>
                                <th>보유머니</th>
                                <th>입금수</th>
                                <th>출금수</th>
                                <th>수익(입금-출금)</th>
                                <th>처리내용</th>
                                <th>포인트</th>
                                <th>처리시간</th>
                                <th>타입</th>
                                <th>이전포인트</th>
                                <th>포인트합</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $value)
                                @php
                                    $member = $value->item->member;
                                    $count_deposit = $member->count_deposit ?? 0;
                                    $total_deposit = $member->sum_deposit ?? 0;
                                    $count_withdraw = $member->count_withdraw ?? 0;
                                    $total_withdraw = $member->sum_withdraw ?? 0;
                                    $total_profit = $member->total_profit;
                                    $message =
                                        $value->phBonusType == \App\Models\BonusConfig::TYPE_ROLLING_BONUS
                                            ? $value->phDescription
                                            : $value->message;
                                @endphp
                                <tr>
                                    <td>{{ $member->partner->mPartnerName ?? '' }}</td>
                                    <td>Lv.<span class="text-green-1">{{ $member->mLevel ?? '' }}</span></td>
                                    <td>
                                        <i class="fa fa-cog config-icon"></i>
                                        <x-common.row_info_money :member="$member"
                                            suffix="point-history-{{ $value->item->miNo }}" />
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
                                                @if ($value->phPoint >= 0) color="#0066ff" @else color="#cc0066" @endif>
                                                <!---->
                                                {{ formatNumber($value->phPoint) }}
                                            </font>
                                        </strong>
                                    </td>
                                    <td>{{ $value->phRegDate }}</td>
                                    <td>{{ $value->pointType }}</td>
                                    <td>
                                        @php
                                            $mPoint = $value->mPoint;
                                            $classPointHistory = $mPoint >= 0 ? 'text-green-2' : '';
                                        @endphp
                                        <span class={{ $classPointHistory }}>{{ formatNumber($mPoint) }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $totalPoints = $mPoint + $value->phPoint;
                                        @endphp
                                        {{ formatNumber($totalPoints) }}
                                    </td>
                                </tr>
                                <tr class="m-0 p-0 height-0">
                                    <td colspan="16" class="m-0 p-0 bg-black-lighter">
                                        <div id="MEMBER_DETAIL{{ $member->mNo }}-point-history-{{ $value->item->miNo }}"
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
                        form="Admin.PointHistory.point_history_payment_recovery_form" />
                </div>
            </div>
        </div>
    </div>
@endsection

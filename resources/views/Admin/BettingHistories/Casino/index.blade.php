@extends('Admin.BettingHistories.page')
@section('content-betting-histories')
    <div class="panel-heading-page flex pb-10 bottom-solid-black space-between">
        <h4 class="panel-title m-5 flex-1">
            <strong>
                <i class="fa fa-arrow-down"></i> BETTING LIST :: 카지노배팅관리
            </strong>
        </h4>
        @include('Admin.BettingHistories.Casino.search')
    </div>

    <div class="mt-10">
        <table class="table table-bordered cst-table-darkbrown mb-0">
            <thead>
                <tr>
                    <th>파트너명</th>
                    <th>레벨</th>
                    <th>아이디 (넉네임)</th>
                    <th>보유머니</th>
                    <th>입금</th>
                    <th>출금</th>
                    <th>수익(입금-출금)</th>
                    <th>배팅 시간</th>


                    <th>게임사</th>
                    <th>게임</th>
                    <th>배팅팀</th>
                    <th>배팅금액</th>
                    <th>적중금액</th>
                    <th style="width: 90px">처리상태</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->member->partner->mPartnerName ?? '' }}</td>
                        <td>LV <span class="text-green-1">{{ $item->member->mLevel }}</span></td>
                        <td>
                            <div class="px-8">
                                <i class="fa fa-cog config-icon" aria-hidden="true"></i>
                                <x-common.row_info_money :member="$item->member"
                                    suffix="betting-histories-{{ $item->member->miNo }}" />
                                ({{ $item->member->mNick }})
                            </div>
                        </td>
                        <td><span class="text-green-3">{{ formatNumber($item->member->totalMoney()) }}원</span></td>
                        <td><span
                                class="text-blue-6 mr-3">{{ formatNumber($item->member->sum_deposit) }}</span>원({{ $item->member->count_deposit ?: 0 }})
                        </td>
                        <td><span
                                class="text-pink-1 mr-3">{{ formatNumber($item->member->sum_withdraw) }}</span>원({{ $item->member->count_withdraw ?: 0 }})
                        </td>
                        <td><span class="text-blue-3">{{ formatNumber($item->member->total_profit) }}</span> 원</td>
                        <td>{{ $item->tRegDate }}</td>

                        <td>{{ $item->game_provider->gpName ?? '' }}</td>
                        <td>{{ $item->gName }}</td>
                        <td>{{ $item->tRoundId }}</td>
                        <td>{{ formatNumber($item->tAmount) }}</td>
                        <td><span
                                class="text-blue-1"><strong>{{ formatNumber($item->calcAmountCasinoAndSlotWin()) }}</strong></span>
                        </td>
                        <td>
                            @if ($item->calcAmountCasinoAndSlotWin() > 0)
                                <button type="button" class="btnstyle1 btnstyle1-primary h-31 modal-transaction-detail"
                                    data-modal="modal_transaction_detail"
                                    data-action="{{ route('admin.ajax-get-transaction-detail', ['uuid' => $item->uuid]) }}">당첨</a>
                                @else
                                    <button type="button" class="btnstyle1 btnstyle1-danger h-31 modal-transaction-detail"
                                        data-modal="modal_transaction_detail"
                                        data-action="{{ route('admin.ajax-get-transaction-detail', ['uuid' => $item->uuid]) }}">낙첨</a>
                            @endif
                        </td>
                    </tr>
                    <tr class="m-0 p-0 height-0">
                        <td colspan="16" class="m-0 p-0 bg-black-lighter">
                            <div id="MEMBER_DETAIL{{ $item->member->mNo }}-betting-histories-{{ $item->miNo }}"
                                class="collapse width-full member-detail"
                                data-url="{{ convertApiDomainToAppDomain(route('admin.status-members.detail', ['id' => data_get($item->member, 'mNo')])) }}">
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if (count($data) == 0)
                    <tr>
                        <td colspan="15">데이터가 없음.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection

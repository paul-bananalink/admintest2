@extends('Admin.Consultation.page')
@section('content-consultation')
    <x-common.panel_heading page="Q&A LIST" title="고객센터(1:1문의) 관리" form="Admin.Consultation.form_search" />
    <div class="box mt-20">
        @if (session('success'))
            <div class="alert alert-success">
                <button class="close" data-dismiss="alert">×</button>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                <button class="close" data-dismiss="alert">×</button>
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif
        {{-- id="consultationTable"  Thêm id="consultationTable" = realtime add <tr></tr> --}}

        <table id="consultationTable" class="table table-bordered cst-table-darkbrown"
            data-action-reply="{{ route('admin.consultation.ajaxShowReply') }}">
            <thead>
                <tr>
                    <th class="align-middle" style="width: 70px">파트너영</th>
                    <th class="align-middle" style="width: 45px">레벨</th>
                    <th class="align-middle" style="width: 15%">아이디 (닉네임)</th>
                    <th class="align-middle" style="width: 90px">보유머니</th>
                    <th class="align-middle">입금</th>
                    <th class="align-middle">출금</th>
                    <th class="align-middle" style="width: 90px">수익(입금-출금)</th>
                    <th class="align-middle" style="width: 120px">문의 시간</th>
                    <th class="align-middle" style="width: 30%">내용</th>
                    <th class="align-middle">삭제</th>
                    <th class="align-middle">세부</th>
                    <th class="align-middle" style="min-width:100px">답변상태</th>
                    <th class="align-middle">메모</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->member->partner->mPartnerName ?? '' }}</td>
                        <td>LV <span class="text-green-1">{{ $item->member->mLevel }}</span></td>
                        <td>
                            <div class="px-8">
                                <i class="fa fa-cog config-icon"></i>
                                <x-common.row_info_money :member="$item" suffix="consultation-{{ $item->id }}" /> ({{ $item->member->mNick }})
                            </div>
                        </td>
                        <td><span class="text-green-3">{{ formatNumber($item->member->totalMoney()) }}원</span></td>
                        <td><span
                                class="text-blue-6 mr-3">{{ formatNumber($item->member->sum_deposit) }}</span>원({{ $item->member->count_deposit ?: 0 }})
                        </td>
                        <td><span
                                class="text-red-4 mr-3">{{ formatNumber($item->member->sum_withdraw) }}</span>원({{ $item->member->count_withdraw ?: 0 }})
                        </td>
                        <td><span class="text-blue-3">{{ formatNumber($item->member->total_profit) }}</span> 원</td>
                        <td>
                            <div>{{ $item->created_at }}</div>
                            <div>{{ $item->date_feedback }}</div>
                        </td>
                        <td style="text-align: inherit">
                            <div>{{ $item->content }}</div>
                            <div class="content-reply-all show-hide-content-{{ $item->id }}">
                                {!! $item->getHtmlReplied() !!}
                            </div>
                            <div class="default-reply reply-content-{{ $item->id }}"></div>
                        </td>
                        <td><a href="#" class="btnstyle1 btnstyle1-danger h-31 px-8 confirm-box"
                                data-route="{{ route('admin.consultation.delete', ['id' => $item->id]) }}"
                                data-method="delete"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        <td>
                            <button type="button" data-toggle="collapse"
                                data-target="#MEMBER_DETAIL{{ $item->member->mNo }}-consultation-{{$item->id}}"
                                class="btnstyle1 btnstyle1-primary btnstyle1-xs text-white">
                                <i class="fa ion-android-add-circle f-s-20 m-t-2"></i>
                            </button>
                        </td>
                        @if (!$item->date_feedback)
                            <td style="width: 80px"><span href="#"
                                    class="btnstyle1 btnstyle1-danger h-31 px-8 reply-cons"
                                    data-item-id="{{ $item->id }}" data-open-reply="{{ 1 }}">답변달기</span>
                            </td>
                        @else
                            <td style="width: 80px"><span href="#"
                                    class="btnstyle1 btnstyle1-primary h-31 px-8 reply-cons"
                                    data-item-id="{{ $item->id }}" data-open-reply="{{ 1 }}">답변 수정</span>
                            </td>
                        @endif
                        <td></td>
                    </tr>
                    <tr class="m-0 p-0 height-0">
                        <td colspan="16" class="m-0 p-0 bg-black-lighter">
                            <div id="MEMBER_DETAIL{{ $item->member->mNo }}-consultation-{{$item->id}}" class="collapse width-full member-detail"
                                data-url="{{ convertApiDomainToAppDomain(route('admin.status-members.detail', ['id' => data_get($item->member, 'mNo')])) }}">
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
    </div>
@endsection

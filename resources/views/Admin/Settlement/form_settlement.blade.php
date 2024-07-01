@extends('Admin.Settlement.page')

@section('content-child')
    <div class="panel-heading-page pb-10 bottom-solid-black">
        <h4 class="panel-title m-5 flex-1">
            <strong>
                <i class="fa fa-arrow-down"></i> 정산 - 파트너
            </strong>
            <p class="m-t-10">정산 - 파트너. *보타/미니게임조합 롤링은 별도로 표기되지 않습니다(라이브롤링/일반롤링으로 계산하여 표기). 지급된 롤링은 지정한 값으로 정산된 것입니다.</p>
        </h4>
        <div>
            <div class="flex space-between">
                <form action="{{ route('admin.settlement.index') }}" method="get">
                    <div>
                        <div class="btn-group">
                            <div class="input-daterange">
                                <div class="el-date-editor el-range-editor el-input__inner el-date-editor--daterange">
                                    <i class="fa fa-calendar"></i>
                                    <input autocomplete="off" placeholder="검색시작날짜" name="start_date" class="el-range-input"
                                        value="{{ request('start_date', today()->format('Y-m-d')) }}" id="js__single-start-date-only" />
                                    <span class="el-range-separator">To</span>
                                    <input autocomplete="off" placeholder="검색마지막날짜" name="end_date" class="el-range-input"
                                        value="{{ request('end_date', today()->format('Y-m-d')) }}" id="js__single-end-date-only" />
                                </div>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btnstyle1 btnstyle1-inverse2 h-31">검색</button>
                        </div>
                    </div>
                </form>
                <div>
                    <div class="btn-group">
                        <select class="form-control input-sm search-input-box height-33 text-white width-full"
                            style="border: 1px solid rgb(17, 17, 17)" name="select_field_search"
                            id="select_field_search">
                            <option value="" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91)"
                                selected>
                                25 행
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="animated fadeInUp panel panel-inverse bg-black-darker2 m-t-10 p-0">
        <div class="no-bg mt-20">
            <table class="table table-bordered table-th-valign-middle table-td-valign-middle text-center text-white no-bg table-striped">
                <thead class="sticky-top top-0">
                    <tr>
                        <th class="text-center bg-black-darker6">#</th>
                        <th class="text-center bg-black-darker6">+-</th>
                        <th class="text-center bg-black-darker6">
                            회원ID
                            <hr class="hr">
                            닉네임
                        </th>
                        <th class="text-center bg-black-darker6">파트너정보</th>
                        <th class="text-center bg-black-darker6">
                            정산 슬롯
                            <hr class="hr">
                            정산 라이브
                        </th>
                        <th class="text-center bg-black-darker6">
                            보유머니
                            <hr class="hr">
                            보너스
                        </th>
                        <th class="text-center bg-black-darker6">
                            충전
                            <hr class="hr">
                            환전
                            <hr class="hr">
                            충환손익
                        </th>
                        <th class="text-center bg-black-darker6">
                            베팅
                            <hr class="hr">
                            당첨
                            <hr class="hr">
                            유효베팅
                            <hr class="hr">
                            롤링
                            <hr class="hr">
                            수익
                            <hr class="hr">
                            죽장
                        </th>
                        <th class="text-center bg-black-darker6">
                            슬롯 베팅
                            <hr class="hr">
                            당첨
                            <hr class="hr">
                            유효베팅
                            <hr class="hr">
                            롤링
                            <hr class="hr">
                            수익
                            <hr class="hr">
                            죽장
                        </th>
                        <th class="text-center bg-black-darker6">
                            라이브 베팅
                            <hr class="hr">
                            당첨
                            <hr class="hr">
                            유효베팅
                            <hr class="hr">
                            롤링
                            <hr class="hr">
                            수익
                            <hr class="hr">
                            죽장
                        </th>
                        <th class="text-center bg-black-darker6">상한공제</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($partners as $i => $partner)
                        <tr>
                            @include('Admin.Settlement.settlement_detail_table_row', [
                                'group' => $i,
                                'id' => $partner['member']->mNo,
                                'level' => 1,
                                'padding' => 0,
                                'isTotal' => true,
                                'partner' => $partner,
                            ])
                        </tr>
                        <tr id="SETTLEMENT_DETAIL-{{ $i }}"
                            class="collapse width-full settlement-detail settlement-detail-group-{{ $i }}"
                            data-url="{{ route('admin.settlement.detail', ['group' => $i, 'id' => $partner['member']->mNo, 'level' => 1, ...request()->query()]) }}">
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="overunderline m-t-10"></div>
    </div>
@endsection

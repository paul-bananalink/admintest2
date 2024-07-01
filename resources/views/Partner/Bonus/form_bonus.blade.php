<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-content">
                @if ($errors->hasBag('bonus-bag'))
                    @foreach ($errors->getBag('bonus-bag')->all() as $error)
                        <div class="alert alert-warning" role="alert">{{ $error }}</div>
                    @endforeach
                @endif
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
                <div class="box-content" style="display: block;">
                    <div class="row">
                        <form action="{{ route('partner.bonus.index') }}" method="get">
                            <div class="col-lg-3">
                                <input id="dateRangePicker"
                                class="form-control cst_panel-title"
                                name="start_and_end_date"
                                type="text"
                                autocomplete="off"
                                value="{{ request('start_and_end_date', '') }}"
                                placeholder="날짜 검색"
                                >
                            </div>
                            <div class="col-lg-2">
                                <input type="text" placeholder="아이디, 닉네임, 예금주 에서 검색" id="search" name="search"
                                    class="form-control" value="{{ request('search', '') }}">
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" name="btn_submit" value="click" class="btn btn-inverse"><i class="fa fa-search"></i> 검색</button>
                            </div>
                        </form>
                    </div>
                    <div class="btn-action">
                        <a href="{{ route(Route::currentRouteName(), ['bonus_all' => true]) }}" @class([
                            'btn',
                            'btn-inverse' => request('bonus_all', false)
                            ])>
                            전체({{data_get($total, 'total_bonus_all', 0)}})
                        </a>
                        <a href="{{ route(Route::currentRouteName(), ['sports_first_time_bonus' => true]) }}" @class([
                            'btn',
                            'btn-inverse' => request('sports_first_time_bonus', false)
                            ])>
                            스포츠첫충({{data_get($total, 'total_sports_first_time_bonus', 0)}})
                        </a>
                        <a href="{{ route(Route::currentRouteName(), ['sports_next_time_bonus' => true]) }}" @class([
                            'btn',
                            'btn-inverse' => request('sports_next_time_bonus', false)
                            ])>
                            스포츠매충({{data_get($total, 'total_sports_next_time_bonus', 0)}})
                        </a>
                        <a href="{{ route(Route::currentRouteName(), ['casino_first_time_bonus' => true]) }}" @class([
                            'btn',
                            'btn-inverse' => request('casino_first_time_bonus', false)
                            ])>
                            카지노첫충({{data_get($total, 'total_casino_first_time_bonus', 0)}})
                        </a>
                        <a href="{{ route(Route::currentRouteName(), ['casino_next_time_bonus' => true]) }}" @class([
                            'btn',
                            'btn-inverse' => request('casino_next_time_bonus', false)
                            ])>
                            카지노매충({{data_get($total, 'total_casino_next_time_bonus', 0)}})
                        </a>
                    </div>
                    <br>
                    <br>
                    <div class="box-table">
                        @if (count($data) == 0)
                            <div class="alert alert-warning" role="alert">No record display to table</div>
                        @else
                            <table id="BonusTable" class="table table-bordered cst-table-darkbrown">
                                <thead>
                                    <tr>
                                        <th class="column-table-member">
                                            <div class="table-title">
                                                파트너명
                                                @include('Partner.Common.pair_button_arrow_sort', [
                                                    'column' => 'm_partner',
                                                ])
                                            </div>
                                        </th>
                                        <th class="column-table-member">
                                            <div class="table-title">
                                                레벨
                                                @include('Partner.Common.pair_button_arrow_sort', [
                                                    'column' => 'm_level',
                                                ])
                                            </div>
                                        </th>
                                        <th class="column-table-member">
                                            <div class="table-title">
                                                아이디(닉네임)
                                                @include('Partner.Common.pair_button_arrow_sort', [
                                                    'column' => 'm_id',
                                                ])
                                            </div>
                                        </th>
                                        <th class="column-table-member">
                                            <div class="table-title">
                                                보유머니
                                                @include('Partner.Common.pair_button_arrow_sort', [
                                                    'column' => 'm_total_money',
                                                ])
                                            </div>
                                        </th>
                                        <th class="column-table-member">
                                            <div class="table-title">
                                                입금(입금수)
                                                @include('Partner.Common.pair_button_arrow_sort', [
                                                    'column' => 'mi_type_UD_AD',
                                                ])
                                            </div>
                                        </th>
                                        <th class="column-table-member">
                                            <div class="table-title">
                                                출금(출금수)
                                                @include('Partner.Common.pair_button_arrow_sort', [
                                                    'column' => 'mi_type_UW_AW',
                                                ])
                                            </div>
                                        </th>
                                        <th class="column-table-member">
                                            <div class="table-title">
                                                수익(입금-출금)
                                                @include('Partner.Common.pair_button_arrow_sort', [
                                                    'column' => 'm_revenue',
                                                ])
                                            </div>
                                        </th>
                                        <th class="column-table-member">
                                            <div class="table-title">
                                                처리내용
                                            </div>
                                        </th>
                                        <th class="column-table-member">
                                            <div class="table-title">
                                                보너스
                                                @include('Partner.Common.pair_button_arrow_sort', [
                                                    'column' => 'mi_bonus_money',
                                                ])
                                            </div>
                                        </th>
                                        <th class="column-table-member">
                                            <div class="table-title">
                                                처리시간
                                                @include('Partner.Common.pair_button_arrow_sort', [
                                                    'column' => 'm_process_date',
                                                ])
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ data_get($item->member->partner, 'pName', '') }}</td>
                                            <td>LV {{ data_get($item->member, 'mLevel') }}</td>
                                            <td>
                                                {{ data_get($item->member, 'mID') }} @if (data_get($item->member, 'mNick')) ({{ data_get($item->member, 'mNick') }}) @endif
                                            </td>
                                            <td>{{ formatNumber((data_get($item->member, 'mMoney') ?? 0) + (data_get($item->member, 'mSportsMoney') ?? 0 ))}}</td>
                                            <td>
                                                {{ formatNumber(data_get($item->member, 'sum_deposit', 0)) }} ({{ data_get($item->member, 'count_deposit', 0) }})
                                            </td>
                                            <td>
                                                {{ formatNumber(data_get($item->member, 'sum_withdraw', 0)) }} ({{ data_get($item->member, 'count_withdraw', 0) }})
                                            </td>
                                            <td>
                                                {{ formatNumber(data_get($item->member, 'sum_deposit', 0) + data_get($item->member, 'sum_withdraw', 0)) }}
                                            </td>
                                            <td>
                                                <a href="#" id="showMoneyInfo" data-url="{{ route('partner.bonus.info', ['id' => data_get($item, 'miNo')]) }}"
                                                    data-target="#myModalViewMoneyInfo" data-toggle="modal" class="text-light open-modal-money-info">
                                                    {{ data_get($item, 'bonusText', '') }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ formatNumber(data_get($item, 'bonusMoney', 0)) }}
                                            </td>
                                            <td>{{ $item->mProcessDate }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    @if ($data)
                        <div class="text-center">
                            {{ $data->appends(request()->query())->links('Admin.Common.pagination') }}
                        </div>
                    @endif
                </div>
                <!-- Modal Create Member-->
                <div class="modal fade" id="myModalViewMoneyInfo" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Money Info</h4>
                            </div>
                            <div class="modal-body">
                                <table id="rechargeTable" data-name="recharge"
                                    class="table table-bordered cst-table-darkbrown">
                                    <thead>
                                        <tr>
                                            <th>파트너명</th>
                                            <th>레벨</th>
                                            <th>아이디(닉네임)</th>
                                            <th>보유머니</th>
                                            <th>입금 (수)</th>
                                            <th>출금 (수)</th>
                                            <th>수익(입금-출금)</th>
                                            <th>은행</th>
                                            <th>입금신청금액</th>
                                            <th>보너스명</th>
                                            <th>신청시간</th>
                                            <th>처리시간</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Modal -->
            </div>
        </div>
    </div>
</div>

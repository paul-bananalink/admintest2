<div class="animated fadeInUp panel panel-inverse bg-black-darker2 m-t-10 p-0">
    <div class="no-bg m-t-10">
        <div id="datalist" style="clear: both; width: 100%">
            <table class="table table-bordered table-td-valign-middle text-center text-white no-bg">
                <thead>
                    <tr>
                        <td class="text-center bg-black-darker6">
                            파트너명
                        </td>
                        <td class="text-center bg-black-darker6">
                            레벨
                        </td>
                        <td class="text-center bg-black-darker6">
                            아이디 (닉네임)
                        </td>
                        <td class="text-center bg-black-darker6">
                            보유머니
                        </td>
                        <td class="text-center bg-black-darker6">
                            입금수
                        </td>
                        <td class="text-center bg-black-darker6">
                            출금수
                        </td>
                        <td class="text-center bg-black-darker6">
                            수익(입금-출금)
                        </td>
                        <td class="text-center bg-black-darker6">
                            처리내용
                        </td>
                        <td class="text-center bg-black-darker6">
                            보너스
                        </td>
                        <td class="text-center bg-black-darker6">
                            처리시간
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td class="bg-black-darker">{{ data_get($item->member->partner, 'pName', '') }}</td>
                            <td class="bg-black-darker">
                                LV <span style="color: #66ff66">{{ data_get($item->member, 'mLevel') }}</span>
                            </td>
                            <td class="bg-black-darker">
                                <div class="height-full width-20 pull-left"
                                    style="padding: 0px 25px 0px 0px; border-right: 1px solid rgb(81, 81, 81);">
                                    <i class="fa fa-gear text-blue cursor f-s-18"></i>
                                </div>
                                {{ data_get($item->member, 'mID') }} ({{ data_get($item->member, 'mNick') }})
                            </td>
                            <td class="bg-black-darker">
                                <span style="color: #5b8631" class="el-tooltip"
                                    aria-describedby="el-tooltip-482" tabindex="0">{{ formatNumber((data_get($item->member, 'mMoney') ?? 0) + (data_get($item->member, 'mSportsMoney') ?? 0 ))}}</span>
                            </td>
                            <td class="bg-black-darker">
                                <span style="color: #0066ff">{{ formatNumber(data_get($item->member, 'sum_deposit', 0)) }}</span>
                                ({{ data_get($item->member, 'count_deposit', 0) }})
                            </td>
                            <td class="bg-black-darker">
                                <span style="color: #cc0066">{{ formatNumber(data_get($item->member, 'sum_withdraw', 0)) }}</span>
                                ({{ data_get($item->member, 'count_withdraw', 0) }})
                            </td>
                            <td class="bg-black-darker">
                                @php $revenue = data_get($item->member, 'sum_deposit', 0) + data_get($item->member, 'sum_withdraw', 0) @endphp
                                <span>
                                    <span style="color: #{{ $revenue > 0 ? '0066ff' : ($revenue < 0 ? 'cc0066' : 'ffffff') }}">
                                        {{ formatNumber($revenue) }}
                                    </span> 원
                                </span>
                            </td>
                            <td class="bg-black-darker text-left">
                                {{ data_get($item, 'bonusText', '') }}
                            </td>
                            <td class="bg-black-darker">
                                <strong>
                                    <span size="3" style="color: #0066ff">{{ formatNumber(data_get($item, 'bonusMoney', 0)) }}</span>
                                </strong>
                            </td>
                            <td class="bg-black-darker">
                                {{ $item->mProcessDate }}
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
        <div style="height: 1px; clear: both"></div>
    </div>
</div>

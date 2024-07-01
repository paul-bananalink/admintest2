<form action="{{ route('admin.page-setting.virtual-sport-config.update') }}" method="POST" id="virtual-sport_config">
    @csrf
    <table class="table table-bordered cst-table-darkbrown table-input-center mb-0" border="1">
        <tr>
            <td rowspan="3" class="h-110" style="width: 8%;">
                <button type="submit" class="btnstyle1 btnstyle1-success height-full width-full p-2">
                    <span class="f-s-14"><strong>가상축구</strong></span><br>
                    <div class="f-s-14 m-t-4">
                        <strong><i class="fa fa-gear"></i> 설정값 저장</strong>
                    </div>
                </button>
            </td>
            <td class="align-top" style="width: 8%; padding-top: 10px !important">배팅차단</td>
            <td class="align-top" style="padding-top: 10px !important">유저배팅중지내용</td>
            <td class="align-top" style="padding-top: 10px !important">배팅마감초</td>
            <td class="align-top" style="padding-top: 10px !important">중복배팅수</td>
            <td class="align-top" style="padding-top: 10px !important">최대 배팅 쫄더수</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <tr class="bg-black-darker">
            <td>
                <x-common.toggle_switch_button isCheck="{{ $data->vcBlockBet ? 1 : 0 }}" id="vcBlockBet"
                    name="vcBlockBet"
                    urlAction="{{ route('admin.page-setting.virtual-sport-config.toggleField', ['field' => 'vcBlockBet']) }}"
                    size="normal" />
            </td>
            <td>
                <input type="text" class="form-control" name="vcNoticeBlockBet"
                    value="{{ $data->vcNoticeBlockBet ?? '' }}">
            </td>
            <td>
                <input type="text" class="formatPercent form-control" name="vcTimeBet"
                    value="{{ $data->vcTimeBet ?? 0 }}">
            </td>
            <td>
                <select class="form-control" name="vcDuplicateBetCount">
                    @foreach (config('sport_config.RANGE_10') as $time)
                        <option value="{{ $time }}" @if (!empty($data->vcDuplicateBetCount) && $data->vcDuplicateBetCount == $time) selected @endif>
                            {{ $time }}회</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="form-control" name="vcMaxBetFolderCount">
                    @foreach (config('sport_config.RANGE_10') as $time)
                        <option value="{{ $time }}" @if (!empty($data->vcMaxBetFolderCount) && $data->vcMaxBetFolderCount == $time) selected @endif>
                            {{ $time }}폴더</option>
                    @endforeach
                </select>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td class="align-top" style="padding-top: 10px !important">회원 낙첨 포인트(%)</td>
            <td class="align-top" style="padding-top: 10px !important">횐원 롤링 포인트(%)</td>
            <td class="align-top" style="padding-top: 10px !important">최소단풀배팅 금액</td>
            <td class="align-top" style="padding-top: 10px !important">최소두풀배팅금액(다풀)</td>
            <td class="align-top" style="padding-top: 10px !important">최소세풀배팅(다풀)</td>
            <td class="align-top" style="padding-top: 10px !important">최대단풀배팅 금액</td>

            <td class="align-top" style="padding-top: 10px !important">최대두풀배팅금액(다풀)</td>
            <td class="align-top" style="padding-top: 10px !important">최대세풀배팅(다풀)</td>
            <td class="align-top" style="padding-top: 10px !important">단풀최대당첨금액</td>
            <td class="align-top" style="padding-top: 10px !important">두풀최대당첨금액</td>
            <td class="align-top" style="padding-top: 10px !important">세풀최대당첨금액</td>
            <td class="align-top" style="padding-top: 10px !important">최대배당</td>
            <td class="align-top" style="padding-top: 10px !important">레벨별 유저배당(%)</td>
        </tr>

        @foreach (config('site_config.LEVELS') as $level)
            <tr>
                <td class="center-middel">{{ $level }} 레별</td>
                @foreach (config('sport_config.FIELDS_VIRTUAL_SPORT_CONFIG_LEVEL') as $field_name => $type)
                    @include('Admin.PageSetting.OptionGames.VirtualSports.item', [
                        'level' => $level,
                        'field_name' => $field_name,
                        'type' => $type,
                    ])
                @endforeach
            </tr>
        @endforeach

        {{-- @foreach (config('site_config.LEVELS') as $level)
            <tr>
                <td>{{$level}} 레별</td>
                <td>
                    <input type="text" class="formatPercent form-control" name="" value="0">
                </td>
                <td>
                    <input type="text" class="formatPercent form-control" name="" value="0">
                </td>
                <td>
                    <input type="text" class="formatPercent form-control" name="" value="0">
                </td>
                <td>
                    <input type="text" class="formatPercent form-control" name="" value="0">
                </td>
                <td>
                    <input type="text" class="formatPercent form-control" name="" value="0">
                </td>
                <td>
                    <input type="text" class="formatPercent form-control" name="" value="0">
                </td>
                <td>
                    <input type="text" class="formatPercent form-control" name="" value="0">
                </td>
                <td>
                    <input type="text" class="formatPercent form-control" name="" value="0">
                </td>
                <td>
                    <input type="text" class="formatPercent form-control" name="" value="0">
                </td>
                <td>
                    <input type="text" class="formatPercent form-control" name="" value="0">
                </td>
                <td>
                    <input type="text" class="formatPercent form-control" name="" value="0">
                </td>
                <td>
                    <input type="text" class="formatPercent form-control" name="" value="0">
                </td>
                <td>
                    <input type="text" class="formatPercent form-control" name="" value="0">
                </td>
            </tr>   
        @endforeach --}}
    </table>
</form>

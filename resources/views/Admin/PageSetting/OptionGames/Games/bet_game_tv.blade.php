{{-- list game cate --}}
<div class="m-t-24 bg-black-2 p-12 radius-6"> 
    <div class="flex space-between text-light f-s-14">
        <div class="flex">
            <div @class(['btnstyle1-success active-success' => ('route' == 'route'), 'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8'])>
                <a href="#" @class(['text-light flex justify-center items-center flex-1'])>
                    주사위결투
                </a>
            </div>
            <div @class(['btnstyle1-success active-success' => ('route' == '1'), 'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8'])>
                <a href="#" @class(['text-light flex justify-center items-center flex-1'])>
                    행운의 바퀴
                </a>
            </div>

            <div @class(['btnstyle1-success active-success' => ('route' == '1'), 'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8'])>
                <a href="#" @class(['text-light flex justify-center items-center flex-1'])>
                    럭키7
                </a>
            </div>

            <div @class(['btnstyle1-success active-success' => ('route' == '1'), 'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8'])>
                <a href="#" @class(['text-light flex justify-center items-center flex-1'])>
                    럭키6
                </a>
            </div>

            <div @class(['btnstyle1-success active-success' => ('route' == '1'), 'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8'])>
                <a href="#" @class(['text-light flex justify-center items-center flex-1'])>
                    럭키5
                </a>
            </div>

            <div @class(['btnstyle1-success active-success' => ('route' == '1'), 'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8'])>
                <a href="#" @class(['text-light flex justify-center items-center flex-1'])>
                    바카라
                </a>
            </div>

            <div @class(['btnstyle1-success active-success' => ('route' == '1'), 'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8'])>
                <a href="#" @class(['text-light flex justify-center items-center flex-1'])>
                    홀덤포커
                </a>
            </div>

            <div @class(['btnstyle1-success active-success' => ('route' == '1'), 'flex btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8'])>
                <a href="#" @class(['text-light flex justify-center items-center flex-1'])>
                    1:1벳
                </a>
            </div>
        </div>
        @include('Admin.PageSetting.OptionGames.Games.visibility_status')
    </div>
</div>

<div class="m-t-24 bg-black-2 radius-6">
    <div class="box">
        <div class="box-content pt-0 pb-0">
            <form action="{{route('admin.page-setting.game-config.update', ['gcType' => $gcType])}}" method="POST" id="bet_game_tv_config">
                @csrf
                <table class="table table-bordered cst-table-darkbrown table-sport-config mb-0 table-input-center" border="1">
                    <tr>
                        <td rowspan="3" class="h-110" style="width: 8%;">
                            <button type="submit" class="btnstyle1 btnstyle1-success height-full width-full p-2">
                                <span class="f-s-14"><strong>벳게임 주사위결투</strong></span><br> 
                                <div class="f-s-14 m-t-4">
                                    <strong><i class="fa fa-gear"></i> 설정값 저장</strong>
                                </div>
                            </button>
                        </td>
                        <td class="align-top" style="width: 12%; padding-top: 10px !important">배팅차단</td>
                        <td class="align-top" style="padding-top: 10px !important">유저배팅중지내용</td>
                        <td class="align-top" style="padding-top: 10px !important">중복배팅수</td>

                        <td class="align-top" style="padding-top: 10px !important"></td>
                        <td class="align-top" style="padding-top: 10px !important"></td>

                        <td class="align-top" style="padding-top: 10px !important">노출여부</td>
                    </tr>

                    <tr class="bg-black-darker">
                        <td>
                            <x-common.toggle_switch_button
                                isCheck="{{ $data->gcBlockBet ? 1 : 0 }}"
                                id="gcBlockBet"
                                name="gcBlockBet"
                                urlAction="{{route('admin.page-setting.game-config.toggleField', 
                                ['field' => 'gcBlockBet', 'gcType' => $gcType])}}"
                                size="normal"
                            />
                        </td>
                        <td>
                            <input type="text" class="form-control" name="gcNoticeBlockBet" value="{{ $data->gcNoticeBlockBet ?? ''}}">
                        </td>
                        <td>
                            <select class="form-control" name="gcDuplicateBetCount">
                                @foreach (config('sport_config.RANGE_10') as $time)
                                    <option value="{{$time}}" @if(!empty($data->gcDuplicateBetCount) && $data->gcDuplicateBetCount == $time) selected @endif>{{$time}}회</option>
                                @endforeach
                            </select>
                        </td>
                        <td></td>
                        <td></td>
                        <td>
                            <x-common.toggle_switch_button
                                    isCheck="{{ $data->gcVisibilityStatus ? 1 : 0 }}"
                                    id="gcVisibilityStatus"
                                    name="gcVisibilityStatus"
                                    urlAction="{{route('admin.page-setting.game-config.toggleField', ['field' => 'gcVisibilityStatus', 'gcType' => $gcType])}}"
                                />
                        </td>
                    </tr>

                    <tr>
                        <td class="align-top" style="padding-top: 10px !important">회원낙첨포인트(%)</td>
                        <td class="align-top" style="padding-top: 10px !important">회원롤팅포인트(%)</td>
                        <td class="align-top" style="padding-top: 10px !important">최소배팅금액</td>
                        <td class="align-top" style="padding-top: 10px !important">최대배팅금액</td>
                        <td class="align-top" style="padding-top: 10px !important">최대당첨금액</td>
                        <td class="align-top" style="padding-top: 10px !important">최대배당</td>
                    </tr>

                    @foreach (config("site_config.LEVELS") as $level)
                        <tr>
                            <td>{{$level}} 레별</td>
                            @foreach (config("sport_config.FIELDS_GAME_CONFIG_LEVEL") as $field_name => $type)
                                @include('Admin.PageSetting.OptionGames.Games.item', [
                                    'level' => $level, 
                                    'field_name' => $field_name,
                                    'type' => $type,
                                    'colspan' => false
                                ])
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </form>
        </div>
    </div>
</div>
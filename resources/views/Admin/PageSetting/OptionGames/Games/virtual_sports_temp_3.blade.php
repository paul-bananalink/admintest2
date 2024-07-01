<form action="{{route('admin.page-setting.sport-config.update')}}" method="POST" id="sport_config">
    @csrf
    <table class="table table-bordered cst-table-darkbrown table-sport-config mb-0" border="1">
        <tr>
            <td rowspan="3" class="h-110" style="width: 8%;">
                <button type="submit" class="btnstyle1 btnstyle1-success height-full width-full p-2">
                    <span class="f-s-14"><strong>가상경마</strong></span><br> 
                    <div class="f-s-14 m-t-4">
                        <strong><i class="fa fa-gear"></i> 설정값 저장</strong>
                    </div>
                </button>
            </td>
            <td class="align-top" style="width: 10%; padding-top: 10px !important">배팅차단</td>
            <td class="align-top" style="padding-top: 10px !important">유저배팅중지내용</td>
            <td class="align-top" style="padding-top: 10px !important">배팅마감초</td>
            <td class="align-top" style="padding-top: 10px !important">중복배팅수</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <tr class="bg-black-darker">
            <td>
                <x-common.toggle_switch_button
                    isCheck="{{ false }}"
                    id="name2"
                    name="name2"
                    urlAction="#" size="normal"
                />
            </td>
            <td>
                <input type="text" class="form-control" name="" value="input text">
            </td>
            <td>
                <input type="text" class="formatPercent form-control" name="" value="0">
            </td>
            <td>
                <select class="form-control" name="">
                    <option value="">1</option>
                    <option value="">2</option>
                </select>
            </td>

            <td></td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td class="align-top" style="padding-top: 10px !important">최소세풀배팅(다풀)</td>
            <td class="align-top" style="padding-top: 10px !important">횐원 롤링 포인트(%)</td>
            <td class="align-top" style="padding-top: 10px !important">최소배팅금액</td>
            <td class="align-top" style="padding-top: 10px !important">최대배팅금액</td>
            <td class="align-top" style="padding-top: 10px !important">최대당첨금액</td>
            <td class="align-top" style="padding-top: 10px !important">최대배당</td>
            <td class="align-top" style="padding-top: 10px !important">레벨별 유저배당(%)</td>
        </tr>

        @foreach (config("site_config.LEVELS") as $level)
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
            </tr>   
        @endforeach
    </table>
</form>
<table class="table table-bordered cst-table-darkbrown" id="table-game-provider">
    <thead>
        <tr>
            <th>프로바이더</th>
            <th class="text-center">사용유무</th>
            <th class="text-center"></th>

            <th>프로바이더</th>
            <th class="text-center">사용유무</th>
            <th class="text-center"></th>

            <th>프로바이더</th>
            <th class="text-center">사용유무</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach ($game_pros as $index => $game_pro)
               <tr>
                @foreach($game_pro as $item)
                    <td>
                        <a href="javascript:void(0)" target-url="{{route('admin.page-setting.get-games', ['gpCode' => data_get($item, 'gpCode')])}}"
                        @class(['text-light', 'btn-gp-name'])>
                            {{data_get($item, 'gpName')}}
                        </a>
                    </td>
                    <td>
                        <x-common.toggle_switch_button
                        isCheck="{{data_get($item, 'gpIsGameProvider', true)}}"
                        urlAction="{{route('admin.page-setting.enable-disable-game-provider', ['gpNo' => data_get($item, 'gpNo')])}}"
                        />
                    </td>
                    <td>
                        <div class="flex-center">
                            <a
                            class="btn btn-sm"
                            href="#table-game-provider"
                            data-target="#modal_open_image"
                            data-toggle="modal"
                            data-url-action="{{ route('admin.game-provider.ajaxUpdate', ['id' => $item->gpNo]) }}"
                            @if ($v = data_get($item, 'gpAvatar', ))
                                data-asset-image="{{asset($v)}}"
                            @else
                                data-asset-image="http://via.placeholder.com/200x150/EFEFEF/AAAAAA?text=no%2Bimage"
                            @endif
                            >
                                <i class="fa fa-edit"></i> 수정
                            </a>
                        </div>
                    </td>
                @endforeach
               </tr>
            @endforeach
        </tr>
    </tbody>
</table>
@include('Admin.Common.modal', [
    'modal_id' => 'modal_open_list_game',
    'modal_title' => '게임기 리스트',
    'modal_content_include_name' => 'Admin.PageSetting.modal_open_game_content'
])
@include('Admin.Common.modal', [
    'modal_id' => 'modal_open_image',
    'modal_title' => '사진 편집',
    'modal_content_include_name' => 'Admin.PageSetting.OptionGames.modal_open_image'
])

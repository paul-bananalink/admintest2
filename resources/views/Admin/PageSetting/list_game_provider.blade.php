<table class="table table-bordered cst-table-darkbrown">
    <thead>
        <tr>
            <th>No</th>
            <th>프로바이더</th>
            <th>사용유무</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($game_pros as $index => $game_pro)
            <tr>
                <td>{{$start_no - $index}}</td>
                <td>
                    @if (request('category') != \App\Models\GameProvider::NAME_CASINO)
                        <a target-url="{{route('admin.page-setting.get-games', ['gpCode' => data_get($game_pro, 'gpCode')])}}"
                        @class(['text-light', 'btn-gp-name'])>
                            {{data_get($game_pro, 'gpName')}}
                        </a>
                    @else
                        {{data_get($game_pro, 'gpName')}}
                    @endif
                </td>
                <td>
                    <x-common.toggle_switch_button
                    isCheck="{{data_get($game_pro, 'gpIsGameProvider', true)}}"
                    urlAction="{{route('admin.page-setting.enable-disable-game-provider', ['gpNo' => data_get($game_pro, 'gpNo')])}}"
                    />
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@if ($game_pros)
    <div class="text-center">
        {{ $game_pros->appends(request()->query())->links('Admin.Common.pagination') }}
    </div>
@endif
@includeWhen(request('category') != \App\Models\GameProvider::NAME_CASINO, 'Admin.Common.modal', [
    'modal_name' => 'modal_open_list_game',
    'modal_title' => '게임기 리스트',
    'modal_content_include_name' => 'Admin.PageSetting.modal_open_game_content'
])

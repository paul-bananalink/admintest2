@php
    $temp = request('temp', 1);
@endphp
<div class="m-t-24 bg-black-2 p-12 radius-6">
    <div class="flex space-between text-light f-s-14">
        <div class="flex">
            <div @class([
                'btnstyle1-success active-success' => $temp == 1,
                'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
            ])>
                <a href="{{ route('admin.page-setting.game-config.index', [
                    'gcType' => \App\Models\MiniGameConfig::TYPE_VIRTUAL_SPORTS,
                    'temp' => 1,
                ]) }}"
                    @class(['text-light flex justify-center items-center flex-1'])>
                    가상축구
                </a>
            </div>
            <div @class([
                'btnstyle1-success active-success' => $temp == 2,
                'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
            ])>
                <a href="{{ route('admin.page-setting.game-config.index', [
                    'gcType' => \App\Models\MiniGameConfig::TYPE_VIRTUAL_SPORTS,
                    'temp' => 2,
                ]) }}"
                    @class(['text-light flex justify-center items-center flex-1'])>
                    가상놓구
                </a>
            </div>

            <div @class([
                'btnstyle1-success active-success' => 'route' == '1',
                'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
            ])>
                <a href="#" @class(['text-light flex justify-center items-center flex-1'])>
                    가상야구
                </a>
            </div>

            <div @class([
                'btnstyle1-success active-success' => $temp == 3,
                'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
            ])>
                <a href="{{ route('admin.page-setting.game-config.index', [
                    'gcType' => \App\Models\MiniGameConfig::TYPE_VIRTUAL_SPORTS,
                    'temp' => 3,
                ]) }}"
                    @class(['text-light flex justify-center items-center flex-1'])>
                    가상경마
                </a>
            </div>

            <div @class([
                'btnstyle1-success active-success' => 'route' == '1',
                'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 mr-8',
            ])>
                <a href="#" @class(['text-light flex justify-center items-center flex-1'])>
                    가상개경주
                </a>
            </div>
        </div>
        <div class="flex items-center gap-10">노출여부:
            <div style="width: 118px">
                <x-common.toggle_switch_button isCheck="{{ true }}" id="test1" name="test1"
                    urlAction="#" size="normal" />
            </div>
        </div>
    </div>
</div>

<div class="m-t-24 bg-black-2 radius-6">
    <div class="box">
        <div class="box-content pt-0 pb-0">
            @include('Admin.PageSetting.OptionGames.Games.virtual_sports_temp_' . $temp)
        </div>
    </div>
</div>

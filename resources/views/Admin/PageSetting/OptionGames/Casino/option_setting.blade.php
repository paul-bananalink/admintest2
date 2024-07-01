
<div class="btn-group">
    <x-common.toggle_switch_button content="카지노 메뉴자체를 막을수 있는 기능"
        isCheck="{{ data_get($site, $ccType == \App\Models\CasinoConfig::TYPE_CASINO ? 'siIsGameProviderCasino' : 'siIsGameProviderSlot', true) }}"
        urlAction="{{ route('admin.page-setting.enable-disable-category', ['category' => $ccType]) }}" />
</div>
@include('Admin.PageSetting.OptionGames.Casino.list_game_provider', [
    'game_pros' => $game_pros,
    'ccType' => $ccType
])

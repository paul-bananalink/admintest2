<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3 class="cst_h3">
                    <i class="fa fa-file"></i> 카지노 설정
                </h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="box-content">
                <div class="btn-group">
                    <x-common.toggle_switch_button content="카지노 메뉴자체를 막을수 있는 기능"
                        isCheck="{{ data_get($site, request('category') == \App\Models\GameProvider::NAME_CASINO ? 'siIsGameProviderCasino' : 'siIsGameProviderSlot', true) }}"
                        urlAction="{{ route('admin.page-setting.enable-disable-category', ['category' => request('category')]) }}" />
                </div>
                @includeWhen(!request('gpCode'), 'Admin.PageSetting.list_game_provider', [
                    'game_pros' => $game_pros,
                    'start_no' => $start_no,
                ])
            </div>
        </div>
    </div>
</div>

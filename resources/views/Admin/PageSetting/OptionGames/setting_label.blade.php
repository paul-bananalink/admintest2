<div class="flex space-between m-t-24 m-b-14 text-light font-bold f-s-14">
    <div><i class="fa fa-cog" aria-hidden="true"></i> 게임별옵션설정</div>
    <div class="flex items-center gap-10">모든 게임 일괄 점검: 
        <div style="width: 118px">
            <x-common.toggle_switch_button content="정상" contentOff="점검"
            isCheck="{{ app('site_info')->siEnableGamesConfig }}" id="siEnableGamesConfig"
            name="siEnableGamesConfig"
            urlAction="{{ route('admin.page-setting.toggle-field', ['field' => 'siEnableGamesConfig']) }}"
            size="big" />
        </div>
    </div>
</div>

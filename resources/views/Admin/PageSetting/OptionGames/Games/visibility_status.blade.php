<div class="flex items-center gap-10">노출여부: 
    <div style="width: 118px">
        <x-common.toggle_switch_button
        isCheck="{{ $data->gcVisibilityAllStatus ? 1 : 0 }}"
        id="gcVisibilityAllStatus"
        name="gcVisibilityAllStatus"
        urlAction="{{route('admin.page-setting.game-config.toggleField', 
        ['field' => 'gcVisibilityAllStatus', 'gcType' => $gcType])}}"
        size="normal"
    />
    </div>
</div>
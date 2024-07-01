<tr class="detail">
    @include('Admin.Settlement.settlement_detail_table_row', [
        'group' => $group,
        'id' => $partner['member']->mNo,
        'level' => $level,
        'padding' => $level,
        'isTotal' => false,
        'partner' => $partner,
    ])
</tr>
@foreach ($children as $i => $child)
    <tr class="child settlement-detail-group-{{ $group }}">
        @include('Admin.Settlement.settlement_detail_table_row', [
            'group' => $group . '-' . $i,
            'id' => $child['member']->mNo,
            'level' => $level + 1,
            'padding' => $level,
            'isTotal' => true,
            'partner' => $child,
        ])
    </tr>
    <tr id="SETTLEMENT_DETAIL-{{ $group }}-{{ $i }}"
        class="collapse width-full settlement-detail child settlement-detail-group-{{ $group }}"
        data-url="{{ route('admin.settlement.detail', ['group' => $group . '-' . $i, 'id' => $child['member']->mNo, 'level' => $level + 1, ...request()->query()]) }}">
    </tr>
@endforeach

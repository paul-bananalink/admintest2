<td>
    <input class="form-control formatMoney" type="text"
        name="sudden_bonus[table][{{ $level }}][{{ $group }}][payment_amount]"
        value="{{ $data['table'][$level][$group]['payment_amount'] ?? '' }}" placeholder="">
</td>
<td>
    <x-common.toggle_switch_button content="지급" contentOff="지급안함"
        isCheck="{{ $data['table'][$level][$group]['is_payment_upon_recharge'] ?? false }}"
        id="sudden_bonus-table-{{ $level }}-{{ $group }}-is_payment_upon_recharge"
        urlAction="{{ route('admin.page-setting.bonus-config.toggleFieldBonusSudden', ['level' => $level, 'group' => $group, 'field' => 'is_payment_upon_recharge']) }}"
        size="big" />
</td>

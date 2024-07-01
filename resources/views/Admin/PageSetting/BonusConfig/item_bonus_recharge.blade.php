<td>
    <input class="form-control formatMoney" type="text"
        name="recharge_bonus[table][{{ $level }}][{{ $group }}][weekday_rate]"
        value="{{ formatNumber(data_get($data, "table.$level.$group.weekday_rate")) }}">
</td>
<td>
    <input class="form-control formatMoney" type="text"
        name="recharge_bonus[table][{{ $level }}][{{ $group }}][weekend_rate]"
        value="{{ formatNumber(data_get($data, "table.$level.$group.weekend_rate")) }}">
</td>
<td>
    <x-common.toggle_switch_button content="지급" contentOff="지급안함"
        isCheck="{{ $data['table'][$level][$group]['is_payment_upon_withdraw'] ?? false }}"
        id="recharge_bonus-is_payment_upon_withdraw-{{ $level }}-{{ $group }}"
        urlAction="{{ route('admin.page-setting.bonus-config.toggleFieldBonusRecharge', ['level' => $level, 'group' => $group, 'field' => 'is_payment_upon_withdraw']) }}"
        size="big" />
</td>

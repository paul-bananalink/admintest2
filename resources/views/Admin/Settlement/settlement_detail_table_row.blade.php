<td class="bg-black-darker p-0">
    <input type="checkbox">
</td>
<td class="bg-black-darker text-left w-100">
    @if ($isTotal && $partner['count_children'] > 0)
        <div class="btn-group">
            <button type="button" data-toggle="collapse" data-target="#SETTLEMENT_DETAIL-{{ $group }}"
                class="btn btn-circle btn-success open-settlement-detail" style="margin-left: {{ $padding * 20 }}px; margin-right: 0">
                <i class="fa fa-plus"></i>
            </button>
            <button type="button" data-toggle="collapse" data-target="#SETTLEMENT_DETAIL-{{ $group }}"
                class="btn btn-circle btn-danger close-settlement-detail d-none"
                style="margin-left: {{ $padding * 20 }}px; margin-right: 0" data-data="settlement-detail-group-{{ $group }}">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    @endif
</td>
<td class="bg-black-darker text-left">
    <div style="margin-left: {{ $padding * 20 }}px">
        {{ $partner['member']->mID }}
        <hr class="hr">
        {{ $partner['member']->mNick }}
    </div>
</td>
<td class="bg-black-darker text-left">
    <i class="ion-person-stalker text-success m-r-4 f-s-16"></i>
    {{ $level == 1 ? '부본' : ($level == 2 ? '총판' : $level . '단계') }}
    <em class="text-primary">{{ $partner['count_children'] > 0 ? $partner['count_children'] : '' }}</em>
</td>
<td class="bg-black-darker text-left">
    <div>죽장 {{ number_format($partner['member']->memberConfig?->mcLossSlotRate, 2) }}%</div>
    <div>롤링 {{ number_format($partner['member']->memberConfig?->mcRollingSlotRate, 2) }}%</div>
    <hr class="hr">
    <div>죽장 {{ number_format($partner['member']->memberConfig?->mcLossCasinoRate, 2) }}%</div>
    <div>롤링 {{ number_format($partner['member']->memberConfig?->mcRollingCasinoRate, 2) }}%</div>
</td>
<td class="bg-black-darker text-right">
    <div class="text-info">{{ formatNumber($isTotal ? $partner['child']['sum_money'] : $partner['parent']['sum_money']) }}</div>
    <hr class="hr">
    <div class="text-pink-1">{{ formatNumber($isTotal ? $partner['child']['sum_point'] : $partner['parent']['sum_point']) }}</div>
</td>
<td class="bg-black-darker text-right">
    <div class="text-info">{{ formatNumber($isTotal ? $partner['child']['sum_recharge'] : $partner['parent']['sum_recharge']) }}</div>
    <hr class="hr">
    <div class="text-pink-1">{{ formatNumber($isTotal ? $partner['child']['sum_withdraw'] : $partner['parent']['sum_withdraw']) }}</div>
    <hr class="hr">
    <div class="text-success">
        {{ formatNumber($isTotal ? $partner['child']['sum_profit_recharge_withdraw'] : $partner['parent']['sum_profit_recharge_withdraw']) }}
    </div>
</td>
<td class="bg-black-darker text-right">
    <div class="text-info">{{ formatNumber($isTotal ? $partner['child']['sum_bet'] : $partner['parent']['sum_bet']) }}</div>
    <hr class="hr">
    <div class="text-pink-1">{{ formatNumber($isTotal ? $partner['child']['sum_win'] : $partner['parent']['sum_win']) }}</div>
    <hr class="hr">
    <div class="text-info">{{ formatNumber($isTotal ? $partner['child']['sum_valid_bet'] : $partner['parent']['sum_valid_bet']) }}</div>
    <hr class="hr">
    <div class="text-danger">{{ formatNumber($isTotal ? $partner['child']['sum_rolling'] : $partner['parent']['sum_rolling']) }}</div>
    <hr class="hr">
    <div class="text-success">{{ formatNumber($isTotal ? $partner['child']['sum_profit_bet_win_rolling'] : $partner['parent']['sum_profit_bet_win_rolling']) }}</div>
    <hr class="hr">
    <div class="text-primary">{{ number_format($isTotal ? $partner['child']['sum_loss'] : $partner['parent']['sum_loss'], 2) }}</div>
</td>
<td class="bg-black-darker text-right">
    <div class="text-info">{{ formatNumber($isTotal ? $partner['child']['sum_bet_slot'] : $partner['parent']['sum_bet_slot']) }}</div>
    <hr class="hr">
    <div class="text-pink-1">{{ formatNumber($isTotal ? $partner['child']['sum_win_slot'] : $partner['parent']['sum_win_slot']) }}</div>
    <hr class="hr">
    <div class="text-info">{{ formatNumber($isTotal ? $partner['child']['sum_valid_bet_slot'] : $partner['parent']['sum_valid_bet_slot']) }}</div>
    <hr class="hr">
    <div class="text-danger">{{ formatNumber($isTotal ? $partner['child']['sum_rolling_slot'] : $partner['parent']['sum_rolling_slot']) }}</div>
    <hr class="hr">
    <div class="text-success">{{ formatNumber($isTotal ? $partner['child']['sum_profit_bet_win_rolling_slot'] : $partner['parent']['sum_profit_bet_win_rolling_slot']) }}</div>
    <hr class="hr">
    <div class="text-primary">{{ number_format($isTotal ? $partner['child']['sum_loss_slot'] : $partner['parent']['sum_loss_slot'], 2) }}</div>
</td>
<td class="bg-black-darker text-right">
    <div class="text-info">{{ formatNumber($isTotal ? $partner['child']['sum_bet_casino'] : $partner['parent']['sum_bet_casino']) }}</div>
    <hr class="hr">
    <div class="text-pink-1">{{ formatNumber($isTotal ? $partner['child']['sum_win_casino'] : $partner['parent']['sum_win_casino']) }}</div>
    <hr class="hr">
    <div class="text-info">{{ formatNumber($isTotal ? $partner['child']['sum_valid_bet_casino'] : $partner['parent']['sum_valid_bet_casino']) }}</div>
    <hr class="hr">
    <div class="text-danger">{{ formatNumber($isTotal ? $partner['child']['sum_rolling_casino'] : $partner['parent']['sum_rolling_casino']) }}</div>
    <hr class="hr">
    <div class="text-success">{{ formatNumber($isTotal ? $partner['child']['sum_profit_bet_win_rolling_casino'] : $partner['parent']['sum_profit_bet_win_rolling_casino']) }}</div>
    <hr class="hr">
    <div class="text-primary">{{ number_format($isTotal ? $partner['child']['sum_loss_casino'] : $partner['parent']['sum_loss_casino'], 2) }}</div>
</td>
<td class="bg-black-darker text-right">
    {{ formatNumber($isTotal ? $partner['child']['sum_deduct'] : $partner['parent']['sum_deduct']) }}
</td>

<td>
@if($type == 'percent')
    <input type="text" class="formatPercent form-control" name="{{ $field_name }}[{{ $level }}]" value="{{$data->$field_name[$level] }}">
@elseif($type == 'money')
    <input type="text" class="formatMoney form-control" name="{{ $field_name }}[{{ $level }}]" value="{{ formatNumber($data->$field_name[$level]) }}">
@endif
</td>

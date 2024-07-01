{{-- @foreach ($data as $key => $value)
    @if (gettype($value) == 'array')
        @php $value = json_encode($value, JSON_PRETTY_PRINT) @endphp
    @endif

    <tr>
        <td style="width: 20%" class="text-center bg-black-darker6">{{ $key }}</td>
        <td class="text-center bg-black-darker p-5">{{ $value }}</td>
    </tr>
@endforeach --}}
<iframe width="100%" height="700px" src="{{ $data['result']['historyUrl'] ?? '' }}" frameborder="0"></iframe>

@foreach ($gameProviders as $index => $providers)
    <tr>
        @foreach ($providers as $item)
            <td style="width: 17%" class="text-center bg-black-darker6">{{ data_get($item, 'gpName') }}</td>
            <td style="width: 8%" class="text-center bg-black-darker p-5">
                <x-common.toggle_switch_button
                    isCheck="{{ $config[data_get($item, 'gpCode')] ?? 1 }}"
                    id="{{data_get($item, 'gpCode')}}"
                    name="{{data_get($item, 'gpCode')}}"
                    urlAction="{{ route('admin.member-config.update-game-provider-by-member', ['mID' => $mID, 'gpType' => $gpType, 'gpCode' => data_get($item, 'gpCode')]) }}"
                />
            </td>
        @endforeach
    </tr>
@endforeach
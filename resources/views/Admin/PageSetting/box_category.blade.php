<div class="box-category">
    <ul>
        <li>
            <a @class(['box-title', (!request('gpCode') ? 'orange' : 'text-light'),])
            href="{{ route('admin.page-setting.setting-category', ['category' => request('category')]) }}">
                전체
            </a>
        </li>
        @foreach ($providers as $item)
            <li>
                <a @class(['box-title', (request('gpCode') == $item->gpCode ? 'orange' : 'text-light'),])
                href="{{ route('admin.page-setting.setting-category', ['category' => request('category'), 'gpCode' => $item->gpCode]) }}">
                    {{ $item->gpName }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

@php
    $badge = $badge ?? false;
    $number = $number ?? false;
    $activeUrl = $activeUrl ?? $routeURL;
    $classActived = url()->current() == $activeUrl ? 'actived' : '';

    if (!empty($subMenu)) {
        $classActived = '';
        foreach ($subMenu as $item) {
            if (url()->current() == $item['routeURL']) {
                $classActived = 'actived';
                break;
            }
        }
    }
@endphp
<li class="has-sub lrspline cursor {{ $classActived }}">
    <a id="{{ $id ?? '' }}" class="pl-5 pr-0" href="{{ $routeURL }}">
        {!! $icon ?? '' !!}
        <div>{{ $text }} 
            @if($number !== false)
                <p class="badge badge-menu-ct badge-square f-s-11 {{ $number > 0 ? '' : 'bg-black-1' }} mb-0 ml-6">{{$number}}</p>
            @endif
        </div>
    </a>
    {{-- Sub Menu --}}
    @if(!empty($subMenu))
        <ul class="sub-menu cursor">
            @foreach ($subMenu as $item)
                <li>
                    <a href="{{ $item['routeURL'] }}" class="{{ isset($item['isMaintaining']) && $item['isMaintaining'] ? 'maintenance-item' : '' }}">{{ $item['title'] }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</li>

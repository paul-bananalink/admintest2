<div class="col-md-12 panel panel-inverse btn-group bg-black-3 m-0 m-t-10 m-b-10 p-5 text-light">
    <div class="col-md-12 p-0 text-center">
        <div class="bg-black-2 col-md-12 text-right">
            <div class="pull-left m-t-10 text-left">
                <div>
                    <span class="f-s-15 m-l-4">
                        <strong>{{ $title }}</strong>
                    </span>
                </div>
                @if ($subTitle)
                    <div>
                        <span class="f-s-12 m-l-4 text-gray">
                            {{ $subTitle }}
                        </span>
                    </div>
                @endif
            </div>
            @if (isset($submit))
                <button type="button" class="btnstyle1 btnstyle1-success btnstyle1-sm height-36 m-t-12 btn-submit"
                    data-action="{{ $submit->attributes['action'] }}" data-item="{{ $submit->attributes['item'] }}"
                    form="{{ $submit->attributes['form'] }}">
                    <strong>내용저장</strong>
                </button>
            @endif
        </div>

        {{ $slot }}
    </div>
</div>

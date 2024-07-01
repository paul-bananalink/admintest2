@if($is_open == 1) 
{{-- open rep --}}
<div class="content-td mt-12">
    <form action="{{ route('admin.consultation.reply', ['id' => $data->id]) }}" method="POST" id="reply-member-{{$data->id}}">
        @csrf
        <div class="form-group">
            <textarea id="editor-cons-{{$data->id}}" class="form-control js__editor text-area-reply" name="content_reply" rows="5">{!! $data->content_reply !!}</textarea>
        </div>
        @if ($templates)
            <div class="form-group text-center">
                @foreach ($templates as $item)
                    <a href="#" class="btnstyle1 btnstyle1-success h-31 mr-3 js__apply-templ mb-3" 
                        data-action="{{ route('admin.note.ajaxGetContentConsultation', ['id' => $item->arNo]) }}"> 
                        {{ $item->arLink }}
                    </a>
                @endforeach
            </div>
        @endif
        <div class="form-group">
            <button type="submit" form="reply-member-{{$data->id}}" class="btnstyle1 height-30 btnstyle1-inverse2 w-full">답변저장하기</button>
        </div>
    </form>
</div>
@endif

<script>
    tinymce.remove();
    tinymce.init({
        license_key: "gpl",
        selector: "#editor-cons-" + {{$data->id}},
        plugins: "table lists",
        branding: false,
        skin: "oxide-dark",
        content_css: "dark",
        promotion: false,
        toolbar: false,
        menubar: false,
        height: 200,
        statusbar: false
    });

    $(".js__apply-templ").on("click", function (e) {
        e.preventDefault();
        var data_action = $(this).data("action");
        $.ajax({
        url: data_action,
        type: "GET",
        success: function (response) {
            if (response.success) {
                tinymce.activeEditor.setContent(response.data.arContent);
            }
        },
        });
    });
</script>
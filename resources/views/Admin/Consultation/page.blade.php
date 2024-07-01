@extends('Admin.page')


@section('content-child')
@yield('content-consultation')
@endsection

@section('custom-css')
    @vite([
        "resources/vite/css/page-consultation/index.css",
    ])
@endsection

@section('custom-js')
<script>
    // $('#js__apply-templ').on('click', function () {
    //     var templateId = $('select[name="template"]').val();
    //     if (templateId) {
    //         $.ajax({
    //             url: "{{ route('admin.template-message.ajaxGetContent', ['id' => 'id']) }}".replace('id', templateId),
    //             type: 'GET',
    //             success: function (response) {
    //                 if (response.success) {
    //                     tinymce.activeEditor.setContent(tinymce.activeEditor.getContent() + response.data.content);
    //                 }
    //             }
    //         });
    //     } else {
    //         alert('템플릿을 선택해주세요.');
    //     }
    // });
</script>
@vite([
    "resources/vite/js/page-consultation/index.js",
])

@endsection

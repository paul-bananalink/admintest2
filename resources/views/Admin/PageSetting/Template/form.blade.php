<div class="row">
    <div class="col-md-12">
        <div class="box">
            <form action="{{ route('admin.page-setting.template.store') }}" method="post">
                @csrf
                <div class="box-content">
                    <div class="tools-bar">
                        <div class="float-left pb-10 pt-10">
                            <strong class="form-title"><i class="fa fa-cog"></i> 쪽지답변 설정</strong>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btnstyle1 btnstyle1-primary h-31 mr-4" id="add-template"> <i
                                    class="fa fa-plus"></i>
                                쪽지답변 매크로 추가
                            </button>
                            <button type="submit" class="btnstyle1 btnstyle1-success h-31"> <i class="fa fa-cog"></i>
                                저장
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-0 mt-12 export-row" id="sortable">
                        @foreach ($templates as $template)
                            <div class="mr-4 p-10 panel-auto-reply mb-12 export-column-6 template-item">
                                <input type="hidden" name="data[{{ $template->id }}][id]" value="{{ $template->id }}">
                                <button
                                    class="btnstyle1 btnstyle1-inverse4 h-33 cancel-btn float-right remove-template"><i
                                        class="fa fa-close"></i>
                                </button>
                                <div class="col-md-8 p-0 mb-4">
                                    <input value="{{ $template->title }}" type="text"
                                        name="data[{{ $template->id }}][title]"
                                        class="form-control width-full template-title">
                                </div>
                                <div class="col-md-12 p-0 mb-4 text-edit-h-280">
                                    <textarea style="overflow-y: auto" class="width-full p-10 template-desc js__editor"
                                        name="data[{{ $template->id }}][content]" cols="20" rows="10">{!! $template->content !!}</textarea>
                                </div>
                                {{-- <div class="col-md-12 p-0 mb-4">
                                    <button
                                        class="btnstyle1 btnstyle1-success h-31 width-full btn-open-modal">내용수정</button>
                                </div> --}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

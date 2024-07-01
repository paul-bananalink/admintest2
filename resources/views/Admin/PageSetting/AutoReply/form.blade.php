<div class="row">
    <div class="col-md-12">
        <form action="{{ route('admin.page-setting.auto-reply.store') }}" method="POST">
            @csrf
            <div class="box">
                <div class="box-content">
                    <div class="tools-bar mt-12 mb-12">
                        <div class="float-left">
                            <strong class="form-title"><i class="fa fa-cog"></i> 자동계좌답변 설졍</strong>
                        </div>
                        <div class="float-right">
                            <button type="submit" id="add-template-quick"
                                class="btnstyle1 btnstyle1-primary h-31 mr-4"> <i class="fa fa-plus"></i>
                                자동계좌답변 매크로 추가
                            </button>
                            <button type="submit" class="btnstyle1 btnstyle1-success h-31"> <i class="fa fa-cog"></i>
                                저장
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-0 mt-12">
                        <div class="col-md-12 m-0 p-0 mt-12 export-row sortable" id="quick-form">
                            @foreach ($quick_types as $type)
                                @include('Admin.PageSetting.AutoReply.quick_form', ['type' => $type])
                            @endforeach
                        </div>
                    </div>
                    <div class="tools-bar">
                        <div class="float-left pb-10 pt-10">
                            <strong class="form-title"><i class="fa fa-cog"></i> 자동답변 설정</strong>
                        </div>
                        <div class="float-right">
                            <button type="submit" id="add-template-normal"
                                class="btnstyle1 btnstyle1-primary h-31 mr-4">
                                <i class="fa fa-plus"></i>
                                자동답변 매크로 추가
                            </button>
                            <button type="submit" class="btnstyle1 btnstyle1-success h-31"> <i class="fa fa-cog"></i>
                                설졍값저장
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12 m-0 p-0 mt-12">
                        <div class="col-md-12 m-0 p-0 mt-12 export-row sortable" id="normal-form">
                            @foreach ($normal_types as $type)
                                @include('Admin.PageSetting.AutoReply.normal_form', ['type' => $type])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

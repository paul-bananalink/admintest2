<x-common.panel_heading icon="fa fa-arrow-down" page="NOTICE LIST" title="곰지/규정 관리" />
<div class="box-content-detail bg-black-darker">
    @php
        $is_create = \Request::route()->getName() == 'admin.notice.rule.index';
        $route = $is_create
            ? route('admin.notice.rule.store')
            : route('admin.notice.rule.edit', ['id' => $notice->ntNo]);
    @endphp

    <form action="{{ $route }}" method="post" class="form-horizontal" id="form-notice-rule">
        @csrf
        <input type="hidden" name="type" value="{{ \App\Models\Notice::RULE_TYPE }}">
        <div class="row">
            <div class="col-md-12">
                <div id="group-return"></div>
                <div class="form-group">
                    <label class="col-xs-3 col-lg-1 control-label">제목</label>
                    <div class="col-sm-9 col-lg-11 controls">
                        <input class="form-control" name="title" type="text"
                            value="{{ $notice->ntTitle ?? old('title', '') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 col-lg-1 control-label control-label">내용</label>
                    <div class="col-sm-9 col-lg-11 controls">
                        <textarea name="content" rows="5" class="form-control js__editor">{!! $notice->ntContent ?? old('content', '') !!}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 col-lg-1 control-label control-label">이미지</label>
                    <div class="col-sm-9 col-lg-11 notice-image controls">
                        <x-common.upload_image index="{{ 0 }}"
                            imageUrl="{{ $notice->ntLogo ?? old('logo', '') }}" name="logo" width="125"
                            height="125" />
                    </div>
                </div>
                <div class="form-group tex-center" style="padding: 20px 0 30px 0">
                    <div class="col-xs-3 col-lg-1 control-label control-label"></div>
                    <div class="col-xs-9 submit-notice">
                        <div class="d-flex" style="width: 30%">
                            @foreach (config('constant_view.NOTICE_CATEGORY.RULES') as $key => $value)
                                <div style="margin-right: 40px">
                                    <label>
                                        <input @checked(isset($notice) && $notice->ntCategory == $key) type="radio" name="category"
                                            value="{{ $key }}">
                                        {{ $value }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btnstyle1 btnstyle1-success btnstyle1-sm h-38 button-send">
                            <i class="fa fa-pencil" style="color: white" aria-hidden="true"></i>공지/규정 저장하기
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </form>
</div>

@if (session('success'))
    <div class="alert alert-success">
        <button class="close" data-dismiss="alert">×</button>
        <strong>Success!</strong> {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        <button class="close" data-dismiss="alert">×</button>
        <strong>Error!</strong> {{ session('error') }}
    </div>
@endif

<div class="box-content-detail bg-black-darker">
    <table class="table table-striped table-bordered table-td-valign-middle text-light text-left f-s-13 dark-table">
        <thead>
            <th class="w-100">No.</th>
            <th class="text-left">공지/규정 내용</th>
            <th class="w-200">상태</th>
        </thead>
        <tbody>
            @foreach ($notices as $index => $notice)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td class="text-left">{{ $notice->ntTitle }}</td>
                    <td>
                        <a class="btnstyle1 btnstyle1-primary btnstyle1-sm"
                            href="{{ route('admin.notice.rule.edit', ['id' => $notice->ntNo]) }}">수정</a>
                        <form class="d-inline-block" method="POST"
                            action="{{ route('admin.notice.rule.in-active', ['id' => $notice->ntNo]) }}">
                            @csrf
                            <button type="submit" class="btnstyle1 btnstyle1-danger btnstyle1-sm">삭제</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if ($notices)
    <div class="text-center">
        {{ $notices->appends(request()->query())->links('Admin.Common.pagination') }}
    </div>
@endif

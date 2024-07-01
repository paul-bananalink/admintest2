<x-common.panel_heading icon="fa fa-arrow-down" page="NOTICE BOARD LIST" title="자유게시판 관리" />
<div class="box-content-detail bg-black-darker">
    @php
        $is_create = \Request::route()->getName() == 'admin.notice.vote.index';
        $route = $is_create
            ? route('admin.notice.vote.store')
            : route('admin.notice.vote.edit', ['id' => $notice->ntNo]);
    @endphp

    <form action="{{ $route }}" method="post" class="form-horizontal" id="form-notice-vote">
        @csrf
        <input type="hidden" name="type" value="{{ \App\Models\Notice::VOTE_TYPE }}">
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

                <div class="form-group">
                    <label class="col-xs-3 col-lg-1 control-label control-label">투표</label>
                    <div class="col-sm-9 col-lg-11 notice-image controls">
                        <table
                            class="table table-striped table-bordered table-td-valign-middle text-light text-left f-s-13 dark-table">
                            <tbody>
                                <tr>
                                    <td class="w-200" style="padding: 10px">전체:</td>
                                    @foreach (config('site_config.LEVELS') as $level)
                                        <td style="padding: 10px">
                                            레벨: {{ $level }}
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="w-200" style="padding: 10px">댓글 가능여부</td>
                                    @foreach (config('site_config.LEVELS') as $level)
                                        <td style="background: #2d353c; padding: 10px">
                                            <x-common.toggle_switch_button content=""
                                                isCheck="{{ $notice->config->ncAvailableOfComments[$level] ?? old('ncAvailableOfComments', false) }}"
                                                value="true" id="ncAvailableOfComments{{ $level }}"
                                                name="ncAvailableOfComments[{{ $level }}]" size="small" />
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        <p class="text-light">
                            <span>투표항목 갯수: <input class="w-80 form-control d-inline-block ml-3 mr-3"
                                    name="ncPollDurationHour" type="number"
                                    value="{{ $notice->config->ncPollDurationHour ?? old('ncPollDurationHour', '') }}">개</span>
                        </p>
                        <p class="text-light">
                            <span>투표기간: <input class="w-80 form-control d-inline-block ml-3 mr-3"
                                    name="ncVotingMemberLevel" type="number"
                                    value="{{ $notice->config->ncVotingMemberLevel ?? old('ncVotingMemberLevel', '') }}">시간</span>
                        </p>
                        <p class="text-light">
                            <span>투표 가능유저 레벨: <input class="w-80 form-control d-inline-block ml-3 mr-3"
                                    name="ncEnableMultipleSelection" type="number"
                                    value="{{ $notice->config->ncEnableMultipleSelection ?? old('ncEnableMultipleSelection', '') }}"></span>
                        </p>

                        <p class="text-light d-inline-block mr-3">
                            <span>복수 선택 가능여부:
                                <x-common.toggle_switch_button content="예" contentOff="아니오"
                                    isCheck="{{ $notice->config->ncEnablePollCancel ?? old('ncEnableMultipleSelection', false) }}"
                                    id="ncEnableMultipleSelection" name="ncEnableMultipleSelection" width="100px"
                                    size="big" />
                            </span>
                        </p>
                        <p class="text-light d-inline-block mr-3">
                            <span>투표 취소 가능여부:
                                <span>
                                    <x-common.toggle_switch_button content="예" contentOff="아니오"
                                        isCheck="{{ $notice->config->ncEnablePollCancel ?? old('ncEnablePollCancel', false) }}"
                                        id="ncEnablePollCancel" name="ncEnablePollCancel" width="100px"
                                        size="big" />
                                </span>
                            </span>
                        </p>
                        <p class="text-light">
                            <span class="mr-3">
                                단 나누기:
                            </span>
                            <select class="form-control w-80 d-inline-block" name="ncDivideByItem" id="ncDivideByItem">
                                @foreach (range(1, 5) as $row)
                                    <option value="{{ $row }}">{{ $row }}출</option>
                                @endforeach
                            </select>
                        </p>
                        @foreach (range(1, 5) as $row)
                            <p class="text-light">
                                <span class="mr-3">
                                    항목 {{ $row }}:
                                </span>
                                @php
                                    $tempNcValue = 'ncValue' . $row;
                                    $tempNcItem = 'ncItem' . $row;
                                @endphp
                                <input placeholder="내용" value="{{ $notice->config->{$tempNcItem} ?? '' }}"
                                    name="ncItem{{ $row }}" type="text" style="width:40%"
                                    class="form-control d-inline-block mr-3">
                                <input placeholder="0" name="ncValue{{ $row }}" type="text"
                                    value="{{ $notice->config->{$tempNcValue} ?? '' }}"
                                    class="form-control w-80 d-inline-block">
                            </p>
                        @endforeach
                    </div>
                </div>
                <div class="form-group tex-center" style="padding: 20px 0 30px 0">
                    <div class="col-xs-3 col-lg-1 control-label control-label"></div>
                    <div class="col-xs-9 submit-notice">
                        <button style="top: -10px" type="submit"
                            class="btnstyle1 btnstyle1-success btnstyle1-sm h-38 button-send">
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
                            href="{{ route('admin.notice.vote.edit', ['id' => $notice->ntNo]) }}">수정</a>
                        <form class="d-inline-block" method="POST"
                            action="{{ route('admin.notice.vote.in-active', ['id' => $notice->ntNo]) }}">
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

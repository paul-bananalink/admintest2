<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3 class="cst_h3">
                    <i class="fa fa-file"></i> 관리자
                </h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="box-content">
                @if ($errors->hasBag('list-admin-setting'))
                    @foreach ($errors->getBag('list-admin-setting')->all() as $error)
                        <div class="alert alert-warning" role="alert">{{$error}}</div>
                    @endforeach
                @endif
                <div class="box-content" style="display: block;">
                    <div class="btn-toolbar pull-right">
                        <div class="btn-group">
                            <a href="{{route('admin.manager-account-setting.index')}}" class="btn btn-circle btn-primary show-tooltip btn-xlarge" data-original-title="페이지 새로고침">
                                <i class="fa fa-refresh"></i>
                            </a>
                            <button class="btn btn-circle btn-primary show-tooltip btn-xlarge" data-original-title="관리자추가" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="box-content">
                        <table class="table table-bordered cst-table-darkbrown">
                            <thead>
                                <tr>
                                    <th>아이디</th>
                                    <th>이름</th>
                                    <th>유형</th>
                                    <th>패스워드</th>
                                    <th>기능</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td>{{$member->mID}}</td>
                                        <td>{{$member->mNick}}</td>
                                        <td>{{$member->mLevel}}</td>
                                        <td id="member-pw-id-{{$member->mNo}}">
                                            <input class="form-control" type="password" id="input-member-pw-id-{{$member->mNo}}" disabled value="********">
                                        </td>
                                        <td>
                                            <button
                                            class="btn btn-circle btn-primary show-tooltip btn-lg btn-open-pass"
                                            data-original-title="수정"
                                            target-value="{{$member->mNo}}"
                                            enable-field="0">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            @if ($member->mStatus != \App\Models\Member::M_STATUS_NINE)
                                                <a class="btn btn-circle btn-success show-tooltip btn-lg"
                                                data-original-title="정지"
                                                href="{{route('admin.manager-account-setting.change-status', ['id' => $member->mNo, 'is_unlock' => 1])}}">
                                                    <i class="fa fa-play"></i>
                                                </a>
                                            @else
                                                <a class="btn btn-circle btn-danger show-tooltip btn-lg"
                                                data-original-title="정지"
                                                href="{{route('admin.manager-account-setting.change-status', ['id' => $member->mNo, 'is_unlock' => 0])}}">
                                                    <i class="fa fa-stop"></i>
                                                </a>
                                            @endif
                                            <a class="btn btn-circle btn-success show-tooltip btn-lg"
                                            data-original-title="접속아이피지정"
                                            href="{{route('admin.manager-account-setting.index', [...request()->all(), 'open_allow_ip' => $member->mID])}}">
                                                <i class="fa fa-link"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($members)
                        <div class="text-center">
                            {{ $members->appends(request()->query())->links('Admin.Common.pagination') }}
                        </div>
                    @endif
                </div>
                <form action="{{route('admin.manager-account-setting.update-password-admin')}}" method="post" id="form-update-password">
                    @csrf
                    <input type="hidden" name="mNo" id="hd-mNo">
                    <input type="hidden" name="mPW" id="hd-mPW">
                </form>
                <!-- Modal ADD IP-->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Admin</h4>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('admin.manager-account-setting.add-admin')}}" method="post" id="add-admin">
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label">아이디</label>
                                        <div class="controls">
                                                <input class="form-control"
                                                name="mID"
                                                type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">이름</label>
                                        <div class="controls">
                                                <input class="form-control"
                                                name="mNick"
                                                type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">비밀번호</label>
                                        <div class="controls">
                                                <input class="form-control"
                                                name="mPW"
                                                type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">유형</label>
                                        <div class="controls">
                                            <select name="mLevel" id="mLevel" class="form-control">
                                                @foreach (config('constant_view.VIEW.selectMLevel') as $m_level)
                                                    @if (auth()->user()->mLevel == config('constant_view.VIEW.M_LEVEL_MA'))
                                                        <option value="{{config('constant_view.VIEW.M_LEVEL_MA')}}">{{config('constant_view.VIEW.M_LEVEL_MA')}}</option>
                                                    @endif
                                                    <option value="{{$m_level}}">{{$m_level}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" form="add-admin" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Modal -->
            </div>
        </div>
    </div>
</div>

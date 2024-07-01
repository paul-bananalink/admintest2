<div class="row">
    <div class="col-md-12">
        <div class="box">
            <x-common.panel_heading page="CASH DATA" title="접속오류기록관리" form="Admin.MemberAccess.search"/>
            <div class="box-content">
                @if ($errors->hasBag('member-access'))
                    @foreach ($errors->getBag('member-access')->all() as $error)
                        <div class="alert alert-warning" role="alert">{{ $error }}</div>
                    @endforeach
                @endif
                <div class="box-content" style="display: block;">
                    <div class="box-content">
                        <table class="table table-bordered cst-table-darkbrown">
                            <thead>
                                <tr>
                                    <th>기록날자</th>
                                    <th>아이디</th>
                                    <th>닉네임</th>
                                    <th>아이피</th>
                                    <th>실패원인</th>
                                    <th>리퍼러</th>
                                    <th>접속환경</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($members_login as $member_login)
                                    <tr>
                                        <td>
                                            <x-common.row_info_money :member="$member_login->member" />
                                        </td>
                                        <td>{{ data_get($member_login, 'mlIpv4') }}</td>
                                        <td>{{ data_get($member_login, 'mlBrowserSystem') }}</td>
                                        <td>{{ data_get($member_login, 'updated_at') }}</td>
                                        <td>
                                            <a class="btn btn-circle btn-magenta show-tooltip btn-lg"
                                                href="https://domain.whois.co.kr/whois/search.php?keyword={{ data_get($member_login, 'mlIpv4') }}"
                                                target="_blank" data-original-title="조회">
                                                <i class="fa fa-cloud"></i>
                                            </a>
                                            <button
                                                class="btn btn-circle btn-primary show-tooltip btn-lg btn-send-value-to-model"
                                                data-original-title="로그아웃" data-toggle="modal"
                                                data-target="#myModalLogout"
                                                target-value="{{ data_get($member_login, 'mNo') }}"
                                                target-value-member="{{ data_get($member_login->member, 'mID') }}">
                                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                    @if ($members_login)
                        <div class="text-center">
                            {{ $members_login->appends(request()->query())->links('Admin.Common.pagination') }}
                        </div>
                    @endif
                </div>
                <!-- Modal Confirm Logout Member-->
                <div class="modal fade" id="myModalLogout" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Logout Member</h4>
                            </div>
                            <div class="modal-body">
                                <label class="control-label">Do you want to logout member: <span
                                        class="badge badge-warning cst_badge" id="member_comfirm">Member
                                        name</span></label>
                                <div class="controls">
                                    <form action="{{ route('admin.info-member-access.member-logout') }}" method="post"
                                        id="member_logout_by_admin">
                                        @csrf
                                        <input type="hidden" name="mNo" id="receive-data-from-btn">
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" form="member_logout_by_admin"
                                    class="btn btn-primary">Yes</button>
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

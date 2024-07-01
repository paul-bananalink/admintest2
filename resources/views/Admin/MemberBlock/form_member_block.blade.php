<div class="row">
    <div class="col-md-12">
        <div class="box">
            <x-common.panel_heading page="CASH DATA" title="접속오류기록관리" form="Admin.MemberBlock.search" />
            <div class="box-content">
                @if ($errors->hasBag('member-access'))
                    @foreach ($errors->getBag('member-access')->all() as $error)
                        <div class="alert alert-warning" role="alert">{{ $error }}</div>
                    @endforeach
                @endif
                <div class="box-content" style="display: block;">
                    <div class="box-content">
                        <table class="table table-bordered cst-table-darkbrown editor-table">
                            <thead>
                                <tr>
                                    <th>IP</th>
                                    <th>닉네임</th>
                                    <th>실패원인</th>
                                    <th>기록날자</th>
                                    <th>접속환경</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $member_login_failed)
                                    <tr>
                                        
                                        <td>{{ data_get($member_login_failed, 'mlfIP') }}</td>
                                        <td class="w-250">
                                            <i class="fa fa-cog config-icon" aria-hidden="true"></i>
                                            <x-common.row_info_money :member="$member_login_failed->member" 
                                            suffix="info-member-block-{{ $member_login_failed->member->mNo }}" />
                                            ({{ $member_login_failed->member->mNick }})
                                        </td>
                                        <td>{{ data_get($member_login_failed, 'mlfReason') }}</td>
                                        <td>{{ data_get($member_login_failed, 'mlfRegDate') }}</td>
                                        <td>{{ data_get($member_login_failed, 'mlfOS') }}</td>
                                    </tr>
                                    <tr class="m-0 p-0 height-0">
                                        <td colspan="16" class="m-0 p-0 bg-black-lighter">
                                            <div id="MEMBER_DETAIL{{ $member_login_failed->member->mNo }}-info-member-block-{{$member_login_failed->member->mNo}}" class="collapse width-full member-detail"
                                                data-url="{{ convertApiDomainToAppDomain(route('admin.status-members.detail', ['id' => data_get($member_login_failed->member, 'mNo')])) }}">
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($data)
                        <div class="text-center">
                            {{ $data->appends(request()->query())->links('Admin.Common.pagination') }}
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

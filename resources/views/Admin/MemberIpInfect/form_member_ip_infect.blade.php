<div class="row">
    <div class="col-md-12">
        <div class="box">
            <x-common.panel_heading page="SAME IP DATA" title="동일 아이피관리" form="Admin.MemberIpInfect.search" />
            <div class="box-content">
                @if ($errors->hasBag('member-ip-infect'))
                    @foreach ($errors->getBag('member-ip-infect')->all() as $error)
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
                                    <th>넉네임</th>
                                    <th>아이피</th>
                                    <th>실패원인</th>
                                    <th>리퍼러</th>
                                    <th>점속환경</th>
                                    <th>자세히</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $item)
                                    <tr>
                                        <td>{{ $item->meRegDate }}</td>
                                        <td><x-common.row_info_money :member="$item->member" /></td>
                                        <td>{{ $item->member->mNick }}</td>
                                        <td>{{ $item->meIP }}</td>
                                        <td></td>
                                        <td>{{ $item->member->partner->pName ?? '' }}</td>
                                        <td>{{ $item->meDeviceID }}</td>
                                        <td>
                                            <button type="button" data-toggle="collapse"
                                                data-target="#MEMBER_DETAIL{{ $item->member->mNo }}-member-infect-{{ $item->meNo }}"
                                                class="btnstyle1 btnstyle1-primary btnstyle1-xs text-white">
                                                <i class="fa ion-android-add-circle f-s-20 m-t-2"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="m-0 p-0 height-0">
                                        <td colspan="16" class="m-0 p-0 bg-black-lighter">
                                            <div id="MEMBER_DETAIL{{ $item->member->mNo }}-member-infect-{{ $item->meNo }}"
                                                class="collapse width-full member-detail"
                                                data-url="{{ convertApiDomainToAppDomain(route('admin.status-members.detail', ['id' => data_get($item->member, 'mNo')])) }}">
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
                                <button type="button" class="clse" data-dismiss="modal">&times;</button>
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

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <x-common.panel_heading page="BLACK USER DATA" title="알박이관리" form="Admin.Blacklist.search"/>
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
                                    <th>기록날짜</th>
                                    <th>이름</th>
                                    <th>계작번호</th>
                                    <th>은행명</th>
                                    <th>전화번호</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blacklist as $member)
                                    <tr>
                                        <td>{{$member->blRegDate}}</td>
                                        <td><x-common.row_info_money :member="$member->member" /></td>
                                        <td>{{$member->member->mBankNumber}}</td>
                                        <td>{{$member->member->mBankName}}</td>
                                        <td>{{$member->member->mPhone}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($blacklist)
                        <div class="text-center">
                            {{ $blacklist->appends(request()->query())->links('Admin.Common.pagination') }}
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

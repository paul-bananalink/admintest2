<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3 class="cst_h3">
                    <i class="fa fa-file"></i> 아이피차단
                </h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="box-content">
                @if ($errors->hasBag('block-ip-setting'))
                    @foreach ($errors->getBag('block-ip-setting')->all() as $error)
                        <div class="alert alert-warning" role="alert">{{$error}}</div>
                    @endforeach
                @endif
                <div class="box-content" style="display: block;">
                    <div class="btn-toolbar pull-right">
                        <div class="btn-group">
                            <button class="btn btn-circle show-tooltip btn-xlarge" data-original-title="IP 추가" data-toggle="modal" data-target="#myModal">
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
                                    <th>IP</th>
                                    <th>등록일</th>
                                    <th>기능</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($member_disallow_ips as $mDiIp)
                                    <tr>
                                        <td>{{$mDiIp->mdiIp}}</td>
                                        <td>{{$mDiIp->mdiRegDate}}</td>
                                        <td>
                                            <button
                                            class="btn btn-circle btn-primary show-tooltip btn-lg btn-send-value-to-model"
                                            data-original-title="삭제"
                                            data-toggle="modal"
                                            data-target="#myModalDeleteIp"
                                            target-value="{{$mDiIp->mdiiNo}}"
                                            target-value-ip="{{$mDiIp->mdiIp}}">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($member_disallow_ips)
                        <div class="text-center">
                            {{ $member_disallow_ips->appends(request()->query())->links('Admin.Common.pagination') }}
                        </div>
                    @endif
                </div>
                <!-- Modal ADD IP-->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add IP</h4>
                            </div>
                            <div class="modal-body">
                                <label class="control-label">IPV4</label>
                                <div class="controls">
                                    <form action="{{route('admin.page-setting.block-ip-save')}}" method="post" id="block-ip">
                                        @csrf
                                        <input class="form-control"
                                        name="mdiIp"
                                        type="text"
                                        placeholder="xxx.xxx.xxx.xxx"
                                        required pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$"
                                        oninvalid="setCustomValidity('Enter IPV4')"
                                        oninput="setCustomValidity('')">
                                        <span class="help-inline">192.168.110.310</span>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" form="block-ip" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Modal -->
                <!-- Modal Confirm Delete IP-->
                <div class="modal fade" id="myModalDeleteIp" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add IP</h4>
                            </div>
                            <div class="modal-body">
                                <label class="control-label">Do you want to delete IPv4: <span class="badge badge-warning cst_badge" id="ip-confirm">123.123.123.123</span></label>
                                <div class="controls">
                                    <form action="{{route('admin.page-setting.block-ip-delete')}}" method="post" id="block-ip-delete">
                                        @csrf
                                        <input type="hidden" name="mdiiNo" id="receive-data-from-btn">
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" form="block-ip-delete" class="btn btn-primary">Yes</button>
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

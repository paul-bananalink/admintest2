<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3 class="cst_h3">
                    <i class="fa fa-file"></i> 접속 아이피지정 ({{$m_id}})
                </h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="box-content">
                @if ($errors->hasBag('allow-ip-setting'))
                    @foreach ($errors->getBag('allow-ip-setting')->all() as $error)
                        <div class="alert alert-warning" role="alert">{{$error}}</div>
                    @endforeach
                @endif
                <div class="box-content" style="display: block;">
                    <div class="btn-toolbar pull-right">
                        <div class="btn-group">
                            <button class="btn btn-circle show-tooltip btn-xlarge" data-original-title="IP 추가" data-toggle="modal" data-target="#myModalCreateMemberAllowIp">
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
                                    <th>IP</th>
                                    <th>등록일</th>
                                    <th>기능</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mAIps as $mAIp)
                                    <tr>
                                        <td>{{$mAIp->mID}}</td>
                                        <td>{{$mAIp->maiIp}}</td>
                                        <td>{{$mAIp->maiRegDate}}</td>
                                        <td>
                                            <button
                                            class="btn btn-circle btn-primary show-tooltip btn-lg btn-send-value-to-model"
                                            data-original-title="삭제"
                                            data-toggle="modal"
                                            data-target="#myModalDeleteIp"
                                            target-value="{{$mAIp->maiNo}}"
                                            target-value-ip="{{$mAIp->maiIp}}">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($mAIps)
                        <div class="text-center">
                            {{ $mAIps->appends(request()->query())->links('Admin.Common.pagination') }}
                        </div>
                    @endif
                </div>
                <!-- Modal ADD IP-->
                <div class="modal fade" id="myModalCreateMemberAllowIp" role="dialog">
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
                                    <form action="{{route('admin.manager-account-setting.allow-ip-save', ['m_id' => $m_id])}}" method="post" id="allow-ip">
                                        @csrf
                                        <input class="form-control"
                                        name="mAIp"
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
                                <button type="submit" form="allow-ip" class="btn btn-primary">Save</button>
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
                                    <form action="{{route('admin.manager-account-setting.allow-ip-delete')}}" method="post" id="allow-ip-delete">
                                        @csrf
                                        <input type="hidden" name="maiNo" id="receive-data-from-btn">
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" form="allow-ip-delete" class="btn btn-primary">Yes</button>
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

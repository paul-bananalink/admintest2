<!-- Modal-->
<div class="modal fade" id="modal_export_member_excel" role="dialog">
    <div class="modal-dialog modal-lg" style="width: 900px;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center">엑셀저장셋팅</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.export-excel') }}" method="post">
                    @csrf
                    <h5 class="mt-12 mb-12 text-blue-7">회원타입</h5>
                    <div class="dark-panel">
                        <div class="export-row">
                            @foreach (array_chunk(config('constant_view.MODAL_EXPORT_EXCEL.TYPE_MEMBER'), 6, true) as $chunk)
                                @foreach ($chunk as $key => $value)
                                    <div class="export-column-6">
                                        <label>
                                            <input type="radio" name="type_member" value="{{ $key }}">
                                            {{ $value }}
                                        </label>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    <h5 class="mt-12 mb-12 text-blue-7">저장옵션</h5>
                    <div class="dark-panel">
                        <div class="export-row">
                            @foreach (array_chunk(config('constant_view.MODAL_EXPORT_EXCEL.OPTION_MEMBER'), 8, true) as $chunk)
                                @foreach ($chunk as $key => $value)
                                    @if (in_array($value, [
                                            config('constant_view.MODAL_EXPORT_EXCEL.OPTION_MEMBER.mRegDate'),
                                            config('constant_view.MODAL_EXPORT_EXCEL.OPTION_MEMBER.mApproveRegDate'),
                                            config('constant_view.MODAL_EXPORT_EXCEL.OPTION_MEMBER.mStatus'),
                                        ]))
                                        @continue
                                    @endif
                                    <div class="export-column-8">
                                        <label>
                                            <input type="checkbox" name="option_member[]" value="{{ $key }}">
                                            {{ $value }}
                                        </label>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    <div class="inline-password">
                        <h5 class="mt-12 mb-12 text-blue-7"><span>엑셀 다운로드 비번</span>
                            <span>
                                <input type="password" class="form-control" name="modal_pw_export" id="modal_pw_export"
                                    placeholder="Password" required>
                                <button class="btn btnstyle1-inverse4 export_excel">엑셀 다운로드</button>
                            </span>
                        </h5>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END Modal -->

<div id="modalMemberBanProvider" class="modal fade">
    <form id="member-ban-provider-form" method="POST" action="">
        @csrf
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="modalLable">카지노 개인설정 (<span class="mNickLabel"></span>)</h3>
                </div>
                <div style="overflow-y: auto;max-height: calc(100vh - 210px)" class="modal-body">
                    <table class="table table-bordered cst-table-darkbrown casino-table" border="1">
                        @foreach ($config['casino_providers'] as $index => $casino_provider)
                        <tr>
                            <td>{{$casino_provider->gpName ?? ''}}</td>
                            <td>
                                <x-common.toggle_switch_button
                                    gpCode="{{$casino_provider->gpCode}}"
                                    name="mBanProviders"
                                />
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <table class="table table-bordered cst-table-darkbrown slot-table" border="1">
                        @foreach ($config['slot_providers'] as $index => $slot)
                        <tr>
                            <td>
                                <a href="javascript:void(0)" target-url="{{route('admin.page-setting.get-games', ['gpCode' => $slot->gpCode])}}"
                                    @class(['text-light', 'btn-gp-name-by-member'])>
                                        {{$slot->gpName ?? ''}}
                                </a>
                            <td>
                                <x-common.toggle_switch_button
                                    gpCode="{{$slot->gpCode}}"
                                    name="mBanSlot"
                                />
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="modal-footer text-center">
                </div>
            </div>
        </div>
    </form>
</div>

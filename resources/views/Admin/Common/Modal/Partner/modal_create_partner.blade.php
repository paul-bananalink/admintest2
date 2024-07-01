<div id="modalCreatePartner" class="modal fade">
    <form id="create-partner" method="POST" action="{{ route('admin.partner.create') }}" action-valid-field="{{ route('admin.partner.ajaxValidData') }}">
        @csrf
        <div class="modal-dialog modal-lg" style="width: 1000px;">
            <div class="modal-content">
                <div class="modal-header bg-black-darker6 text-light text-center" style="border-bottom: none">
                    <button type="button" class="close text-light" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="modalLable" class="text-light">파트너 신규등록 모달</h3>
                </div>
                <div class="modal-body bg-black-darker">
                    <table class="table table-bordered cst-table-darkbrown text-center mb-0">
                        <tr>
                            <td class="content-middle content-label w-152">구분</td>
                            <td class="content-middle">
                                <div class="form-group">
                                    <select name="pType" class="form-control">
                                        <option value="">- 선택 -</option>
                                        @foreach (app('site_info')->siPartners as $k => $item)
                                            <option value="{{ $k }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    <div class="show-input-mID"></div>
                                </div>
                            </td>
                            <td class="content-middle content-label w-152">수익배분</td>
                            <td class="content-middle">
                                <div class="form-group">
                                    <select name="pProfitType" class="form-control">
                                        <option value="">- 선택 -</option>
                                        @foreach (config('constant_view.PARTNER_PROFIT_TYPE') as $k => $item)
                                            <option value="{{ $k }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label w-152">아이디</td>
                            <td class="content-middle flex">
                                <input type="text" name="mID" class="form-control">
                                <button style="padding: 8px; margin-left: 10px" type="button"
                                    class="btn btn-circle btn-fill btn-bordered btn-primary btn-to-pink checkMemberId">
                                    <i class="fa fa-search"></i>
                                </button>
                            </td>
                            <td class="content-middle content-label w-152">패스워드</td>
                            <td class="content-middle">
                                <input type="password" name="mPW" class="form-control bg-input border-solid-black">
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label w-152">파트너명</td>
                            <td class="content-middle">
                                <input type="text" name="pName" class="form-control">
                            </td>
                            <td class="content-middle content-label w-152">닉네임</td>
                            <td class="content-middle flex">
                                <input type="text" name="mNick" class="form-control">
                                <button style="padding: 8px; margin-left: 10px" type="button"
                                    class="btn btn-circle btn-fill btn-bordered btn-primary btn-to-pink checkUniqueNickName">
                                    <i class="fa fa-search"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label w-152">상태</td>
                            <td class="content-middle">
                                <div class="form-group">
                                    <select name="mStatus" class="form-control">
                                        <option value="">- 선택 -</option>
                                        @foreach (\App\Models\Member::STATUS_MEMBER_TO_STRING as $k => $item)
                                            <option value="{{ $k }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td class="content-middle content-label w-152">커미션</td>
                            <td class="content-middle">
                                <input type="text" name="pCommissions" class="form-control" placeholder="%">
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label w-152">전화번호</td>
                            <td class="content-middle">
                                <input type="text" name="mPhone" class="form-control">
                            </td>
                            <td class="content-middle content-label w-152">은행명</td>
                            <td class="content-middle">
                                <div class="form-group">
                                    <select name="mBankName" class="form-control">
                                        <option value="">- 선택 -</option>
                                        @foreach (config("constant_view.BANKS") as $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label w-152">예금주</td>
                            <td class="content-middle">
                                <input type="text" name="mBankOwner" class="form-control">
                            </td>
                            <td class="content-middle content-label w-152">계좌번호</td>
                            <td class="content-middle">
                                <input type="text" name="mBankNumber" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label w-152">쿠폰여부</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button 
                                    isCheck="{{ 0 }}"
                                    id="pIsCoupon"
                                    name="pIsCoupon"
                                />
                            </td>
                            <td class="content-middle content-label w-152">룰렛자동지급여부</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button 
                                    isCheck="{{ 0 }}"
                                    id="pIsAutoPayRoulette"
                                    name="pIsAutoPayRoulette"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label w-152">하부요율설정</td>
                            <td class="content-middle" colspan="3">
                                <x-common.toggle_switch_button 
                                    isCheck="{{ 0 }}"
                                    id="pIsSubRateConfig"
                                    name="pIsSubRateConfig"
                                />
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label w-152">파트너정보</td>
                            <td class="content-middle" colspan="3">
                                <textarea name="pNote" class="form-control" cols="30" rows="10"></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer text-center bg-black-darker" style="border: none">
                    <button type="submit" class="btnstyle1 btnstyle1-success height-31 w-full">저장</button>
                </div>
            </div>
        </div>
    </form>
</div>

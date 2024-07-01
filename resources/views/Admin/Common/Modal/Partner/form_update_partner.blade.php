<form id="update-partner" method="POST" action="{{ route('admin.partner.update', ['pNo' => $data->pNo]) }}" data-pno="{{ $data->pNo }}">
    @csrf
    <div class="modal-dialog modal-lg" style="width: 1000px;">
        <div class="modal-content">
            <div class="modal-header bg-black-darker6 text-light text-center" style="border-bottom: none">
                <button type="button" class="close text-light" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="modalLable" class="text-light">파트너 수정</h3>
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
                                        <option @selected($data->pType === $k) value="{{ $k }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                                <div class="show-input-mID">
                                    @if($data->pType === 'distributor' || $data->pType === 'agency')
                                        <div class="flex">
                                            <input type="text" name="mMemberID" placeholder="추천인을" class="form-control" value="{{ $data->member->mMemberID }}">                           
                                            <button type="button" class="btn btn-circle btn-fill btn-bordered btn-primary btn-to-pink checkMMemberIdByTypeUpdate"><i class="fa fa-search"></i></button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="content-middle content-label w-152">수익배분</td>
                        <td class="content-middle">
                            <div class="form-group">
                                <select name="pProfitType" class="form-control">
                                    <option value="">- 선택 -</option>
                                    @foreach (config('constant_view.PARTNER_PROFIT_TYPE') as $k => $item)
                                        <option @selected($data->pProfitType === $k) value="{{ $k }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="content-middle content-label w-152">아이디</td>
                        <td class="content-middle flex">
                            <input type="text" id="mID" class="form-control" value="{{ $data->mID }}" disabled>
                        </td>
                        <td class="content-middle content-label w-152">패스워드</td>
                        <td class="content-middle">
                            <input type="password" name="mPW" class="form-control bg-input border-solid-black">
                        </td>
                    </tr>
                    <tr>
                        <td class="content-middle content-label w-152">파트너명</td>
                        <td class="content-middle">
                            <input type="text" name="pName" class="form-control" value="{{ $data->pName }}">
                        </td>
                        <td class="content-middle content-label w-152">닉네임</td>
                        <td class="content-middle flex">
                            <input type="text" name="mNick" class="form-control" value="{{ $data->member->mNick }}">
                            <button style="padding: 8px; margin-left: 10px" type="button"
                                class="btn btn-circle btn-fill btn-bordered btn-primary btn-to-pink checkUniqueNickNameUpdate">
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
                                        <option @selected($data->member->mStatus == $k) value="{{ $k }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td class="content-middle content-label w-152">커미션</td>
                        <td class="content-middle">
                            <input type="text" name="pCommissions" class="form-control" placeholder="%" value="{{ $data->pCommissions }}">
                        </td>
                    </tr>
                    <tr>
                        <td class="content-middle content-label w-152">전화번호</td>
                        <td class="content-middle">
                            <input type="text" name="mPhone" 
                            value="{{ $data->member->mPhoneCom ? hashString($data->member->mPhone) : $data->member->mPhone }}" 
                            class="form-control">
                        </td>
                        <td class="content-middle content-label w-152">은행명</td>
                        <td class="content-middle">
                            <div class="form-group">
                                <select name="mBankName" class="form-control">
                                    <option value="">- 선택 -</option>
                                    @foreach ($bankList as $item)
                                        <option @selected($item === $data->member->mBankName) value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="content-middle content-label w-152">예금주</td>
                        <td class="content-middle">
                            <input type="text" name="mBankOwner" class="form-control" value="{{ $data->member->mBankOwner }}">
                        </td>
                        <td class="content-middle content-label w-152">계좌번호</td>
                        <td class="content-middle">
                            <input type="text" name="mBankNumber" class="form-control" value="{{ $data->member->mBankNumber }}">
                        </td>
                    </tr>
                    <tr>
                        <td class="content-middle content-label w-152">쿠폰여부</td>
                        <td class="content-middle">
                            <x-common.toggle_switch_button 
                                isCheck="{{ $data->pIsCoupon }}"
                                id="pIsCoupon"
                                name="pIsCoupon-{{ $data->pNo }}"
                                urlAction="{{ route('admin.partner.toggle-field', ['field' => 'pIsCoupon', 'pNo' => $data->pNo]) }}"
                            />
                        </td>
                        <td class="content-middle content-label w-152">룰렛자동지급여부</td>
                        <td class="content-middle">
                            <x-common.toggle_switch_button 
                                isCheck="{{ $data->pIsAutoPayRoulette }}"
                                id="pIsAutoPayRoulette"
                                name="pIsAutoPayRoulette-{{ $data->pNo }}"
                                urlAction="{{ route('admin.partner.toggle-field', ['field' => 'pIsAutoPayRoulette', 'pNo' => $data->pNo]) }}"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="content-middle content-label w-152">하부요율설정</td>
                        <td class="content-middle" colspan="3">
                            <x-common.toggle_switch_button 
                                isCheck="{{ $data->pIsSubRateConfig }}"
                                id="pIsSubRateConfig"
                                name="pIsSubRateConfig-{{ $data->pNo }}"
                                urlAction="{{ route('admin.partner.toggle-field', ['field' => 'pIsSubRateConfig', 'pNo' => $data->pNo]) }}"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="content-middle content-label w-152">파트너정보</td>
                        <td class="content-middle" colspan="3">
                            <textarea name="pNote" class="form-control" cols="30" rows="10">{{ $data->pNote }}</textarea>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer text-center bg-black-darker" style="border: none">
                <button data-load="{{ route('admin.partner.indexLevel', ['level_type' => 'all']) }}" type="submit" class="btnstyle1 btnstyle1-success height-31 w-full">저장</button>
            </div>
        </div>
    </div>
</form>

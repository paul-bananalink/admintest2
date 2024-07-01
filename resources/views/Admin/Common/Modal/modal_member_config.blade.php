<div id="modalMemberConfig" class="modal fade">
    <form id="member-config-form" method="POST" action="{{ route('admin.status-members.create-or-update-member') }}">
        @csrf
        <input type="hidden" name="mNo" id="mNo" value="">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="modalLable"></h3>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered cst-table-darkbrown text-center">
                        <tr>
                            <td class="content-middle content-label">상태</td>
                            <td class="content-middle">
                                <div class="form-group">
                                    <select name="mStatus" id="mStatus" class="form-control">
                                        @foreach ($config['status'] as $index => $status)
                                            <option value="{{ $index }}">{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td class="content-middle content-label">탈퇴</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button id="mForceLogout" name="mForceLogout" />
                            </td>
                            <td class="content-middle content-label">아이디</td>
                            <td class="content-middle">
                                <input type="text" readonly id="mID" name="mID" placeholder="member ID"
                                    class="form-control">
                            </td>
                            <td class="content-middle content-label">닉네임</td>
                            <td class="content-middle">
                                <input type="text" readonly name="mNick" id="mNick" placeholder="Nick name"
                                    class="form-control">
                            </td>
                            <td class="content-middle content-label">상태</td>
                            <td class="content-middle" rowspan="9"
                                style="vertical-align: middle; text-align: center; line-height: 1.5;">
                                <button class="btn btn-primary"
                                    style="writing-mode: vertical-lr; height: 30%;">저장하기</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label">입금제한</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcIsRechargeLimit" id="mcIsRechargeLimit" />
                            </td>
                            <td class="content-middle content-label">출금제한</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcIsWithdrawLimit" id="mcIsWithdrawLimit" />
                            </td>
                            <td class="content-middle content-label">파트너명</td>
                            <td class="content-middle"><input type="text" readonly class="form-control"
                                    id="partnerName" placeholder="Partner name"></td>
                            <td class="content-middle content-label">추천인</td>
                            <td class="content-middle"><input readonly name="mMemberID" id="mMemberID" type="text"
                                    class="form-control" placeholder="Member name invite">
                            </td>
                            <td class="content-middle content-label" rowspan="8">
                                <textarea name="mNote" class="form-control" id="mNote" cols="30" rows="20"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label">비번오류초기화</td>
                            <td class="content-middle"><button class="btn btn-primary" id="resetPW">초기화하기</button>
                            </td>
                            <td class="content-middle content-label">알박이</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcIsBlackList" id="mcIsBlackList" />
                            </td>
                            <td class="content-middle content-label">레벨</td>
                            <td class="content-middle">
                                <select name="mLevel" id="mLevelConfig" class="form-control">
                                    @foreach ($config['levels'] as $level)
                                        <option value="{{ $level }}">{{ $level }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="content-middle content-label">비밀번호</td>
                            <td class="content-middle"><input type="password" name="mPW" placeholder="Password@123"
                                    class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label">예금주</td>
                            <td class="content-middle">
                                <input class="form-control" name="mBankOwner" id="mBankOwner"
                                    placeholder="Bankowner" type="text">
                            </td>
                            <td class="content-middle content-label">전화번호</td>
                            <td class="content-middle">
                                <input class="form-control mPhone" name="mPhone" id="mPhone"
                                    placeholder="+82..." type="text">
                            </td>
                            <td class="content-middle content-label">은행명</td>
                            <td class="content-middle">
                                <select name="mBankName" id="mBankName" class="form-control">
                                    @foreach ($config['banks'] as $bank)
                                        <option value="{{ $bank }}">{{ $bank }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="content-middle content-label">계좌번호</td>
                            <td class="content-middle">
                                <input class="form-control" name="mBankNumber" id="mBankNumber"
                                    placeholder="Bank number" type="text">
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label">스포츠</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcSport" id="mcSport" />
                            </td>
                            <td class="content-middle content-label">미니게임</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcMiniGame" id="mcMiniGame" />
                            </td>
                            <td class="content-middle content-label">최종접속일</td>
                            <td class="content-middle"><span id="mLoginDateTime"></span></td>
                            <td class="content-middle content-label">1:1계좌</td>
                            <td class="content-middle">
                                <button data-target="#modal-send-note" data-toggle="modal" class="btn btn-primary"
                                    onclick="event.preventDefault()">은행명</button>
                                <button data-target="#modal-send-note" data-toggle="modal" class="btn btn-primary"
                                    onclick="event.preventDefault()">은행명</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label">카지노</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcCasino" id="mcCasino" />
                            </td>
                            <td class="content-middle content-label">슬롯</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcSlot" id="mcSlot" />
                            </td>
                            <td class="content-middle content-label">접속아이피</td>
                            <td class="content-middle"><span id="mLoginIP"></span></td>
                            <td class="content-middle content-label">접속기기</td>
                            <td class="content-middle" style="max-width: 200px"><span id="mlBrowserSystem"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label">미니게임</td>
                            <td class="content-middle">
                                <button class="btn btn-primary not-available">제한설정</button>
                                <!-- Button open modal minigame -->
                            </td>
                            <td class="content-middle content-label">카지노</td>
                            <td class="content-middle">
                                <button class="btn btn-primary open-modal-ban-casino"
                                    data-target="#modalMemberBanProvider" data-toggle="modal">제한설정</button>
                                <!-- Button open modal casino -->
                            </td>
                            <td class="content-middle content-label">슬롯</td>
                            <td class="content-middle">
                                <button class="btn btn-primary open-modal-ban-slot"
                                    data-target="#modalMemberBanProvider" data-toggle="modal">제한설정</button>
                                <!-- Button open modal slot -->
                            </td>
                            <td class="content-middle content-label" colspan="2"></td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label">단폴</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcEnableSinglePole" id="mcEnableSinglePole" />
                            </td>
                            <td class="content-middle content-label">단풀제한금액</td>
                            <td class="content-middle">
                                <input class="form-control formatMoney" name="mcSinglePoleAmount"
                                    id="mcSinglePoleAmount" placeholder="단풀제한금액	" type="text">
                            </td>
                            <td class="content-middle content-label">두폴</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcEnableMultiPole" id="mcEnableMultiPole" />
                            </td>
                            <td class="content-middle content-label">두폴제한금액</td>
                            <td class="content-middle">
                                <input class="form-control formatMoney" name="mcMultiPoleAmount"
                                    id="mcMultiPoleAmount" placeholder="두폴제한금액" type="text">
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label">접속도메인</td>
                            <td class="content-middle">
                                <span id="mPosition"></span>
                            </td>
                            <td class="content-middle content-label">롤링완료</td>
                            <td class="content-middle">
                                <span>스포츠</span>
                                <x-common.toggle_switch_button name="mcSportsRolling" id="mcSportsRolling" />
                                <span>카지노</span>
                                <x-common.toggle_switch_button name="mcCasinoRolling" id="mcCasinoRolling" />
                            </td>
                            <td class="content-middle content-label">전액출금</td>
                            <td>
                                <button class="btn btn-primary" id="withdrawMonney">출금</button>
                            </td>
                            <td class="content-middle content-label" colspan="2"></td>
                        </tr>
                        <tr class="content-middle content-label">
                            <td colspan="10">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <input id="descriptionWallet" name="descriptionWallet" class="form-control"
                                            type="text" value="" placeholder="지갑선택">
                                    </div>
                                    <div class="col-lg-3">
                                        <select id="walletType" name="walletType" class="form-control">
                                            {{-- <option value="sports">스포츠캐쉬</option> --}}
                                            <option value="casino_slot">카지노캐쉬</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input id="moneyNumber" class="form-control" type="number" min="0"
                                            placeholder="캐쉬금액">
                                    </div>
                                    <div class="col-lg-3">
                                        <button id="moneySubmit"
                                            class="btn btn-primary open-modal-ban-slot">저장</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
            </div>
        </div>
    </form>
</div>

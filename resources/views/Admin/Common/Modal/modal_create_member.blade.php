<div id="modalCreateMember" class="modal fade">
    <form id="create-member-form" method="POST" action="{{ route('admin.status-members.create-or-update-member') }}">
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3>회원추가</h3>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered cst-table-darkbrown text-center">
                        <tr>
                            <td class="content-middle content-label">상태</td>
                            <td class="content-middle">
                                <div class="form-group">
                                    <select name="mStatus" class="form-control">
                                        @foreach ($config['status'] as $index => $status)
                                            <option value="{{ $index }}">{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td class="content-middle content-label">탈퇴</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mForceLogout" />
                            </td>
                            <td class="content-middle content-label">아이디</td>
                            <td class="content-middle">
                                <div class="table_flex">
                                    <input type="text" name="mID" placeholder="member ID" class="form-control create-mID">
                                    <button style="padding: 8px; margin-left: 10px" type="button"
                                           
                                            target-url="{{ route('admin.status-members.check-unique-member-id') }}"
                                            token="{{ csrf_token() }}"
                                            class="btn btn-circle btn-fill btn-bordered btn-primary btn-to-pink check-mID"
                                            >
                                            <i class="fa fa-search"></i>
                                    </button>
                                </button>
                                </div>
                            </td>

                            <td class="content-middle content-label">닉네임</td>
                            <td class="content-middle">
                                <div class="table_flex">
                                    <input type="text" name="mNick" placeholder="Nick name" class="form-control create-mNick">
                                    <button style="padding: 8px; margin-left: 10px" type="button"             
                                                target-url="{{ route('admin.status-members.check-member-nick') }}"
                                                token="{{ csrf_token() }}"
                                                class="btn btn-circle btn-fill btn-bordered btn-primary btn-to-pink checkNickName"
                                                >
                                                <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="content-middle content-label">상태</td>
                            <td class="content-middle" rowspan="9"
                                style="vertical-align: middle; text-align: center; line-height: 1.5;">
                                <button type="button" class="btn btn-primary" id="btn-create-member"
                                    style="writing-mode: vertical-lr; height: 30%;">저장하기
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label">레벨</td>
                            <td class="content-middle">
                                <select name="mLevel" class="form-control">
                                    @foreach ($config['levels'] as $level)
                                        <option value="{{ $level }}">{{ $level }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="content-middle content-label">비밀번호</td>
                            <td class="content-middle"><input type="password" name="mPW" placeholder="Password@123"
                                    class="form-control">
                            </td>
                            <td class="content-middle content-label">파트너명</td>
                            <td colspan="3" class="content-middle">
                                <div class="table_flex">
                                    <input type="text" class="form-control create-mMemberID" name="mMemberID" placeholder="Partner name">
                                    <button style="padding: 8px; margin-left: 10px" type="button"
                                            id="btn-check-member-id"
                                            target-url="{{ route('admin.status-members.check-member-id') }}"
                                            token="{{ csrf_token() }}"
                                            class="btn btn-circle btn-fill btn-bordered btn-primary btn-to-pink checkMMemberId">
                                            <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="content-middle content-label" rowspan="8">
                                <textarea name="mNote" class="form-control" cols="30" rows="20"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label">예금주</td>
                            <td class="content-middle">
                                <input class="form-control" name="mBankOwner" placeholder="Bankowner"
                                    type="text">
                            </td>
                            <td class="content-middle content-label">전화번호</td>
                            <td class="content-middle">
                                <input class="form-control mPhone" name="mPhone"
                                    placeholder="+82..." type="text">
                            </td>
                            <td class="content-middle content-label">은행명</td>
                            <td class="content-middle">
                                <select name="mBankName" class="form-control">
                                    @foreach ($config['banks'] as $bank)
                                        <option value="{{ $bank }}">{{ $bank }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="content-middle content-label">계좌번호</td>
                            <td class="content-middle">
                                <input class="form-control" name="mBankNumber"
                                    placeholder="Bank number" type="text">
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label">롤링완료</td>
                            <td class="content-middle">
                                <span>스포츠</span>
                                <x-common.toggle_switch_button name="mcSportsRolling" />
                                <span>카지노</span>
                                <x-common.toggle_switch_button name="mcCasinoRolling"/>
                            </td>
                            <td class="content-middle content-label">알박이</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcIsBlackList"/>
                            </td>
                            <td class="content-middle content-label">입금제한</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcIsRechargeLimit"/>
                            </td>
                            
                            <td class="content-middle content-label">출금제한</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcIsWithdrawLimit"/>
                            </td>
                            
                        </tr>
                        
                        <tr>
                            <td class="content-middle content-label">스포츠</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcSport" isCheck="true"/>
                            </td>
                            <td class="content-middle content-label">미니게임</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcMiniGame" isCheck="true"/>
                            </td>
                            <td class="content-middle content-label">카지노</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcCasino" isCheck="true"/>
                            </td>
                            <td class="content-middle content-label">슬롯</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcSlot"isCheck="true"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="content-middle content-label">단폴</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcEnableSinglePole"/>
                            </td>
                            <td class="content-middle content-label">단풀제한금액</td>
                            <td class="content-middle">
                                <input class="form-control formatMoney" name="mcSinglePoleAmount" placeholder="단풀제한금액	"
                                    type="text">
                            </td>
                            <td class="content-middle content-label">두폴</td>
                            <td class="content-middle">
                                <x-common.toggle_switch_button name="mcEnableMultiPole" />
                            </td>
                            <td class="content-middle content-label">두폴제한금액</td>
                            <td class="content-middle">
                                <input class="form-control formatMoney" name="mcMultiPoleAmount" placeholder="두폴제한금액"
                                    type="text">
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

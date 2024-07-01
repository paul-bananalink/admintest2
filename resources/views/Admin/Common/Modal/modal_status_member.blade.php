<div id="modal-status-member" class="modal fade">
    <form id="formEditMember" method="POST" action="#">
        @csrf
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="modalLableStatusMember"></h3>
                </div>
              
                    <div class="modal-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>추천인 ID:</td>
                                    <td colspan="3"><input class="form-control mID" name="mMemberID" type="text" placeholder="Referrer id">  
                                    </td>
                                    <td>
                                        <button type="button" id="btn-check-member-id"
                                        target-url="{{ route('admin.status-members.check-member-id') }}"
                                        token="{{ csrf_token() }}"
                                        class="btn btn-circle btn-fill btn-bordered btn-primary btn-to-pink">
                                        <i class="fa fa-search"></i>
                                        </button>
                                     </td>
                                </tr>
                                <tr>
                                    <td>은행명:</td>
                                    <td colspan="3"><input class="form-control" name="title" name="mBankName" id="mBankNumberInput" type="text" placeholder="Bank Name"></td>
                                </tr>
                                <tr>
                                    <td>Password:</td>
                                    <td colspan="3"><input class="form-control" name="title" id="mPWInput" type="text"></td>
                                </tr>
                                <tr>
                                    <td>예금주:</td>
                                    <td colspan="3"><input class="form-control" name="title" id="mBankOwnerInput" type="text"></td>
                                </tr>
                                <tr>
                                    <td>환전 Password:</td>
                                    <td >
                                        <input type="password" name="mBankExchangePW" id="mBankExchangePW"
                                            placeholder="Password Bank Exchange" class="form-control">
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td>
                                        전화번호:
                                    </td>
                                    <td>
                                        <input
                                            type="text" name="mPhone" placeholder="Phone Number" class="form-control mPhone">
                                    </td>
                                </tr>
                                <tr>
                                    <td>닉네임 <span>*</span></td>
                                    <td>
                                        <input type="text" name="mNick" placeholder="Nick Name" class="form-control mNick" readonly>
                                    </td>
                                    <td>상태</td>
                                    <td>
                                        <select name="mStatus" class="form-control mStatus" tabindex="1">
                                            @foreach (\App\Models\Member::STATUS_MEMBER_TO_STRING as $key => $value)
                                                <option value="{{ $key }}"
                                                    @if (old('mStatus', 'mStatus' == $key)) selected @endif>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tbody>
                        </table>       
                    </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>

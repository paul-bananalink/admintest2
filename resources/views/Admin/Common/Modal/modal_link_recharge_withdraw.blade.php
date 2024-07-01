<div id="modal-link" class="modal fade">
    <form id="formRechargeOrWithdraw" method="POST" action="">
        <input type="hidden" name="miType" id="type">
        @csrf
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="modal_lable_recharge_withdraw"></h3>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td>회원 ID:</td>
                            <td id="mID_modal"></td>
                            <td>관리자암호:</td>
                            <td><input required placeholder="password@123" name="password" type="password"
                                    class="form-control"></td>
                        </tr>
                        <tr>
                            <td>지갑선택:</td>
                            <td colspan="3">
                                <select class="form-control input-sm wallet" tabindex="1" name="miWallet">
                                    <option value="sports">스포츠</option>
                                    <option value="casino_slot">카지노/슬롯</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>스포츠: </p>
                                <p>카지노/슬롯: </p>
                            </td>
                            <td>
                                <p id="mSportsMoney1" class="mSportsMoney1">0</p>
                                <p id="mMoney1" class="mMoney1">0</p>
                            </td>
                            <td>충전금액:</td>
                            <td><input required placeholder="1,000,000" name="miBankMoney" type="text"
                                    class="form-control formatMoney"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                    <button type="submit" class="btn btn-primary" id="submitButton">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>

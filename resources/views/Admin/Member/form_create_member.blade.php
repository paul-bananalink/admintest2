<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3 class="cst_h3">
                    <i class="fa fa-file"></i> 회원추가
                </h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="box-content">
                @if ($errors->hasBag('create-member-bag'))
                @foreach ($errors->getBag('create-member-bag')->all() as $error)
                <div class="alert alert-warning" role="alert">{{$error}}</div>
                @endforeach
                @endif
                
                <div class="box-content" style="display: block;">
                    <div class="box-content">
                        <form action="{{route('admin.status-members.create-member')}}" method="POST" id="form-create-member">
                            @csrf
                            <table class="table table-bordered cst-table-darkbrown">
                                <tbody>
                                    <tr>
                                        <td>추천인 ID</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input value="{{old('mMemberID')}}" type="text" name="mMemberID" placeholder="Referrer id" class="form-control mMemberID">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" id="btn-check-member-id" target-url="{{route('admin.status-members.check-member-id')}}" class="btn btn-circle btn-fill btn-bordered btn-primary btn-to-pink">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>은행명</td>
                                        <td>
                                            <input value="{{old('mBankName')}}" type="text" name="mBankName" id="mBankName" placeholder="Bank Name" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>회원 ID <span>*</span></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input value="{{old('mID')}}" type="text" name="mID" id="mID" placeholder="User ID" class="form-control">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" id="btn-check-unique-member-id" target-url="{{route('admin.status-members.check-unique-member-id')}}" class="btn btn-circle btn-fill btn-bordered btn-primary btn-to-pink">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>계좌번호</td>
                                        <td>
                                            <input value="{{old('mBankNumber')}}" type="text" name="mBankNumber" id="mBankNumber" placeholder="Bank Number" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Password <span>*</span></td>
                                        <td>
                                            <input type="password" name="mPW" id="mPW" placeholder="Password" class="form-control">
                                        </td>
                                        <td>
                                            예금주
                                        </td>
                                        <td>
                                            <input value="{{old('mBankOwner')}}" type="text" name="mBankOwner" id="mBankOwner" placeholder="Bank Owner" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>환전 Password</td>
                                        <td>
                                            <input type="password" name="mBankExchangePW" id="mBankExchangePW" placeholder="Password Bank Exchange" class="form-control">
                                        </td>
                                        <td>
                                            전화번호
                                        </td>
                                        <td>
                                            <input value="{{old('mPhone')}}" type="text" name="mPhone" id="mPhone" placeholder="Phone Number" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>닉네임</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input value="{{old('mNick')}}" type="text" name="mNick" id="mNick" placeholder="Nick Name" class="form-control">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" id="btn-check-member-nick" target-url="{{route('admin.status-members.check-member-nick')}}" class="btn btn-circle btn-fill btn-bordered btn-primary btn-to-pink">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>상태</td>
                                        <td>
                                            <select name="mStatus" id="mStatus" class="form-control" tabindex="1">
                                                @foreach (\App\Models\Member::STATUS_MEMBER_TO_STRING as $key => $value)
                                                <option value="{{$key}}" @if (old('mStatus')==$key) selected @endif>{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Memo</td>
                                        <td colspan="3">
                                            <textarea name="mNote" id="mNote" rows="5" class="form-control" placeholder="Memo member">{{old('mNote')}}</textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center">
                                <button type="button" id="btn-create-member" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                <a href="{{route('admin.status-members.index')}}" class="btn">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

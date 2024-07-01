@extends('Partner.Manager.page')
@section('content-partner-manager')
    <x-common.panel_heading page="PARTNER LIST" title="파트너관리" form="Partner.Manager.form_search"/>
    <div id="MEMBER_CSEP_MAKE" class="collapseck width-full collapse">
        <div class="panel panel-inverse bg-black-3 m-t-20 m-b-50 p-10">
            <div class="panel-heading p-b-13" style="background: rgb(34, 34, 34);">
                <div class="panel-heading-btn">
                    <div class="btn-group m-t-7 display-none">
                        <select id="new_mb_type" class="btn form-control input-sm input-box width-150 height-33 text-white text-left" style="border: 1px solid rgb(17, 17, 17);">
                            <option value="1" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">부본사</option>
                            <option value="2" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">총판</option>
                            <option value="3" class="p-5" style="border-bottom: 1px solid rgb(49, 65, 91);">대리점</option>
                        </select>
                    </div>
                    <div class="btn-group">
                        <input type="text" id="new_mb_id" placeholder="아이디" class="form-control p-5 m-0 search-input-box height-33 text-white">
                    </div> 
                    <div class="btn-group">
                        <input type="text" id="new_mb_pw" placeholder="패스워드" class="form-control p-5 m-0 search-input-box height-33 text-white">
                    </div> 
                    <div class="btn-group">
                        <input type="text" id="new_mb_nick" placeholder="파트너명" class="form-control p-5 m-0 search-input-box height-33 text-white">
                    </div> 
                    <div class="btn-group">
                        <button type="button" class="btnstyle1 btnstyle1-success btnstyle1-sm height-31">파트너생성</button>
                    </div>
                </div>
                <h4 class="panel-title m-5">:: 파트너추가-관리자</h4>
            </div>
        </div>
    </div>
    <div class="box mt-20">
        <table class="table table-bordered cst-table-darkbrown">
            <thead>
                <tr>
                    <th>상태</th>
                    <th>구분</th>
                    <th>등록일</th>
                    <th>아이디</th>

                    <th>파트너명</th>
                    <th>회원수</th>
                    <th>회원캐쉬</th>
                    <th>가입인증코드</th>

                    <th>커미션</th>
                    <th>최종정산일</th>
                    <th>입금총액(수)</th>
                    <th>출금총액(수)</th>

                    <th>수익(입금-출금)</th>
                    <th>배팅총액(수)</th>
                    <th>수익금</th>
                    <th>상세</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="label f-s-12 p-5 label-primary">정상활동</span></td>
                    <td><span class="text-green-2 font-bold">부본사</span></td>
                    <td>2024-05-22 17:48:38</td>
                    <td>asas100</td>
                    <td>테스트스트</td>
                    <td>0</td>
                    <td>500,000</td>
                    <td>asdasd</td>
                    <td>0%</td>
                    <td>2024-05-22</td>
                    <td><span class="text-blue-6 mr-3 font-bold">0</span> <span class="text-gray-3">(0)</span></td>
                    <td><span class="red mr-3 font-bold">0</span> <span class="text-gray-3">(0)</span></td>
                    <td><span class="red mr-3 font-bold">0</span></td>
                    <td><span class="text-light mr-3 font-bold">0</span> <span class="text-gray-3">(0)</span></td>
                    <td><span class="label-blue-dark px-8 py-4">수익금 : <span class="red">0</span> / 출금가능금액 : <span class="text-blue-6">0</span></span></td>
                    <td><a href="#" class="btnstyle1 btnstyle1-info h-31 text-white px-8"><i class="fa fa-bar-chart-o text-gray2 f-s-20 m-t-2"></i></a></td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
            
        </div>
    </div>
@endsection
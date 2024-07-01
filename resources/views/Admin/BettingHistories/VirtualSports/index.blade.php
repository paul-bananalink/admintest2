@extends('Admin.BettingHistories.page')
@section('content-betting-histories')
<div class="panel-heading-page flex pb-10 bottom-solid-black space-between">
    <h4 class="panel-title m-5 flex-1">
        <strong>
            <i class="fa fa-arrow-down"></i> BETTING LIST :: 가상게임 배팅관리
        </strong>
    </h4>
    @include('Admin.BettingHistories.VirtualSports.search')
</div>
<div class="pt-10">
    <div class="">
        <div @class(['btnstyle1-success active-success' => true, 'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 inline-block mb-3'])>
            <a href="#" @class(['text-light flex justify-center items-center flex-1 h-full'])>
                스포츠
            </a>
        </div>
        @for ($i = 0; $i < 4; $i++)
            <div @class(['btnstyle1-success active-success' => false, 'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 inline-block mb-3'])>
                <a href="#" @class(['text-light flex justify-center items-center flex-1 h-full'])>
                    스포츠
                </a>
            </div>
        @endfor
    </div>
</div>

<div class="pt-10 top-solid-blue-light">
    <div class="bg-blue-light">
        <div class="p-10">
            <div class="flex space-between items-center p-8 bg-black-4 radius-6">
                <div class="">
                    <strong>
                        <span class="text-light">파트너명 : </span> 
                        <span class="text-blue-1 mr-12">지인 추천</span>
                        <span class="text-light">레벨 : </span>
                        <span class="text-blue-1">LV</span> <span class="text-green-1 mr-12">4</span>
                        <span class="text-light">아이디 : </span><a href="#" class="blue"><i class="fa fa-cog"></i></a>
                        <span class="text-blue-1">mID (mNick)</span>
                    </strong>
                </div>
                <div><strong><span class="text-blue-1">가상북구</span></strong></div>
            </div>
            <div>
                <table class="table table-bordered cst-table-darkbrown table-history mb-0">
                    <thead>
                        <tr>
                            <th style="width: 150px">회차</th>
                            <th style="width: 16%">리그명</th>
                            <th style="width: 30%" colspan="2">홈팀 vs 원정팀</th>
                            <th>경기타입</th>
    
                            <th>배당률</th>
                            <th>경기결과</th>
                            <th>배팅 결과</th>
                            {{-- <th style="width: 250px">수동처리</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>15:58</td>
                            <td style="text-align: left !important;"><span><i class="fa fa-futbol-o" aria-hidden="true"></i></span> | <span>Superleague</span></td>
    
                            <td style="width: 15%" class="team-home">
                                <div class="flex space-between">
                                    <div class="text-red-3">홈</div>
                                    <div class="flex-1 text-center">Barcelona</div>
                                </div>
                            </td>
                            <td style="width: 15%" class="team-way">
                                <div class="flex space-between">
                                    <div class="flex-1 text-center">City</div>
                                    <div class="text-blue-6">원</div>
                                </div>
                            </td>
                            <td>승무패 - Cly</td>
                            <td>2.35</td>
                            <td></td>
                            <td>진행중</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex space-between items-center p-8 bg-black-4 f-s-14 radius-6">
                <div class=""><strong><span class="text-light">배팅시간 : </span> <span class="text-blue-1">2024-05-27 15:35:45</span></strong></div>
                <div class="font-bold">
                    <span class="text-light">예상당첨금액 : </span>
                    <span class="text-blue-1">(배팅금 31,000 X 배당률 4.29) = </span><span class="text-warning">132,990원</span> 
                    <span class="text-blue-1">/</span>
                    <span class="text-light"> 당첨금액 : </span>
                    <span class="text-red-3">0원</span>
                    <a href="#" class="btnstyle1 btnstyle1-info h-31 ml-12">정 산대기</a>
                </div>
            </div>
        </div>
        {{-- table 2 --}}
        <div class="p-10">
            <div class="flex space-between items-center p-8 bg-black-4 radius-6">
                <div class="">
                    <strong>
                        <span class="text-light">파트너명 : </span> 
                        <span class="text-blue-1 mr-12">지인 추천</span>
                        <span class="text-light">레벨 : </span>
                        <span class="text-blue-1">LV</span> <span class="text-green-1 mr-12">4</span>
                        <span class="text-light">아이디 : </span><a href="#" class="blue"><i class="fa fa-cog"></i></a>
                        <span class="text-blue-1">mID (mNick)</span>
                    </strong>
                </div>
                <div><strong><span class="text-blue-1">가상북구</span></strong></div>
            </div>
            <div>
                <table class="table table-bordered cst-table-darkbrown table-history mb-0">
                    <thead>
                        <tr>
                            <th style="width: 150px">회차</th>
                            <th style="width: 16%">리그명</th>
                            <th style="width: 30%" colspan="2">홈팀 vs 원정팀</th>
                            <th>경기타입</th>
    
                            <th>배당률</th>
                            <th>경기결과</th>
                            <th>배팅 결과</th>
                            {{-- <th style="width: 250px">수동처리</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>15:58</td>
                            <td style="text-align: left !important;"><span><i class="fa fa-futbol-o" aria-hidden="true"></i></span> | <span>Superleague</span></td>
    
                            <td style="width: 15%" class="team-home">
                                <div class="flex space-between">
                                    <div class="text-red-3">홈</div>
                                    <div class="flex-1 text-center">Barcelona</div>
                                </div>
                            </td>
                            <td style="width: 15%" class="team-way">
                                <div class="flex space-between">
                                    <div class="flex-1 text-center">City</div>
                                    <div class="text-blue-6">원</div>
                                </div>
                            </td>
                            <td>승무패 - Cly</td>
                            <td>2.35</td>
                            <td></td>
                            <td>진행중</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex space-between items-center p-8 bg-black-4 f-s-14 radius-6">
                <div class=""><strong><span class="text-light">배팅시간 : </span> <span class="text-blue-1">2024-05-27 15:35:45</span></strong></div>
                <div class="font-bold">
                    <span class="text-light">예상당첨금액 : </span>
                    <span class="text-blue-1">(배팅금 31,000 X 배당률 4.29) = </span><span class="text-warning">132,990원</span> 
                    <span class="text-blue-1">/</span>
                    <span class="text-light"> 당첨금액 : </span>
                    <span class="text-red-3">0원</span>
                    <a href="#" class="btnstyle1 btnstyle1-info h-31 ml-12">정 산대기</a>
                </div>
            </div>
        </div>

        {{-- table 3 --}}
        <div class="p-10">
            <div class="flex space-between items-center p-8 bg-black-4 radius-6">
                <div class="">
                    <strong>
                        <span class="text-light">파트너명 : </span> 
                        <span class="text-blue-1 mr-12">지인 추천</span>
                        <span class="text-light">레벨 : </span>
                        <span class="text-blue-1">LV</span> <span class="text-green-1 mr-12">4</span>
                        <span class="text-light">아이디 : </span><a href="#" class="blue"><i class="fa fa-cog"></i></a>
                        <span class="text-blue-1">mID (mNick)</span>
                    </strong>
                </div>
                <div><strong><span class="text-blue-1">가상북구</span></strong></div>
            </div>
            <div>
                <table class="table table-bordered cst-table-darkbrown table-history mb-0">
                    <thead>
                        <tr>
                            <th style="width: 150px">회차</th>
                            <th style="width: 16%">리그명</th>
                            <th style="width: 30%" colspan="2">홈팀 vs 원정팀</th>
                            <th>경기타입</th>
    
                            <th>배당률</th>
                            <th>경기결과</th>
                            <th>배팅 결과</th>
                            {{-- <th style="width: 250px">수동처리</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>15:58</td>
                            <td style="text-align: left !important;"><span><i class="fa fa-futbol-o" aria-hidden="true"></i></span> | <span>Superleague</span></td>
    
                            <td style="width: 15%" class="team-home">
                                <div class="flex space-between">
                                    <div class="text-red-3">홈</div>
                                    <div class="flex-1 text-center">Barcelona</div>
                                </div>
                            </td>
                            <td style="width: 15%" class="team-way">
                                <div class="flex space-between">
                                    <div class="flex-1 text-center">City</div>
                                    <div class="text-blue-6">원</div>
                                </div>
                            </td>
                            <td>승무패 - Cly</td>
                            <td>2.35</td>
                            <td></td>
                            <td>진행중</td>
                        </tr>
                        <tr>
                            <td>15:58</td>
                            <td style="text-align: left !important;"><span><i class="fa fa-futbol-o" aria-hidden="true"></i></span> | <span>Superleague</span></td>
    
                            <td style="width: 15%" class="team-home">
                                <div class="flex space-between">
                                    <div class="text-red-3">홈</div>
                                    <div class="flex-1 text-center">Barcelona</div>
                                </div>
                            </td>
                            <td style="width: 15%" class="team-way">
                                <div class="flex space-between">
                                    <div class="flex-1 text-center">City</div>
                                    <div class="text-blue-6">원</div>
                                </div>
                            </td>
                            <td>승무패 - Cly</td>
                            <td>2.35</td>
                            <td></td>
                            <td>진행중</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex space-between items-center p-8 bg-black-4 f-s-14 radius-6">
                <div class=""><strong><span class="text-light">배팅시간 : </span> <span class="text-blue-1">2024-05-27 15:35:45</span></strong></div>
                <div class="font-bold">
                    <span class="text-light">예상당첨금액 : </span>
                    <span class="text-blue-1">(배팅금 31,000 X 배당률 4.29) = </span><span class="text-warning">132,990원</span> 
                    <span class="text-blue-1">/</span>
                    <span class="text-light"> 당첨금액 : </span>
                    <span class="text-red-3">0원</span>
                    <a href="#" class="btnstyle1 btnstyle1-info h-31 ml-12">정 산대기</a>
                </div>
            </div>
        </div>
    </div> 
</div>

@endsection
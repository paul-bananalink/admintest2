@extends('Admin.BettingHistories.page')
@section('content-betting-histories')
<div class="panel-heading-page flex pb-10 bottom-solid-black space-between">
    <h4 class="panel-title m-5 flex-1">
        <strong>
            <i class="fa fa-arrow-down"></i> BETTING LIST :: 스포츠게임배팅관리 | 현재배팅액 : (<span class="text-orange-1">6,709,049</span> 원)
        </strong>
    </h4>
    @include('Admin.BettingHistories.Realtime.search')
</div>
<div class="pt-10 top-solid-blue-light">
    <div class="p-10 bg-blue-light">
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
        </div>
        <div>
            <table class="table table-bordered cst-table-darkbrown table-history mb-0">
                <thead>
                    <tr>
                        <th style="width: 150px">경기 시간</th>
                        <th style="width: 16%">리그명</th>
                        <th style="width: 30%" colspan="2">출팁 vs 원정팀</th>
                        <th>경기타인</th>
                        <th>배팅팀&종류/기준</th>
                        <th>배달률</th>
                        <th>경기결과</th>
                        <th>배팅 결과</th>
                        {{-- <th style="width: 250px">수동처리</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-05-27 19:30:00</td>
                        <td style="text-align: left !important;"><span><i class="fa fa-futbol-o" aria-hidden="true"></i></span> | <span>VPL 1</span></td>

                        <td style="width: 15%" class="team-home">
                            <div class="flex space-between">
                                <div class="text-red-3">홈</div>
                                <div class="flex-1 text-center">Melborune Victory NPL</div>
                            </div>
                        </td>
                        <td style="width: 15%" class="team-way">
                            <div class="flex space-between">
                                <div class="flex-1 text-center">Preston Lions</div>
                                <div class="text-blue-6">원</div>
                            </div>
                        </td>

                        <td><span class="text-green-3">홈님의 오버언더</span></td>
                        <td style="text-align: left !important;">
                            <span>
                                <a href="#" class="btnstyle1 btnstyle1-success h-31 mr-6">
                                    <i class="fa fa-eye text-dark" aria-hidden="true"></i>
                                </a></span> | <span>오버 (0.5)
                            </span>
                        </td>
                        <td>1.45</td>
                        <td></td>
                        <td>대기중</td>
                        {{-- <td>
                            <a href="#" class="btnstyle1 btnstyle1-warning h-31">답변완료</a>
                            <a href="#" class="btnstyle1 btnstyle1-primary h-31">답변완료</a>
                            <a href="#" class="btnstyle1 btnstyle1-danger h-31">답변완료</a>
                        </td> --}}
                    </tr>
                    <tr>
                        <td>2024-05-27 19:30:00</td>
                        <td style="text-align: left !important;"><span><i class="fa fa-futbol-o" aria-hidden="true"></i></span> | <span>VPL 1</span></td>

                        <td style="width: 15%" class="team-home">
                            <div class="flex space-between">
                                <div class="text-red-3">홈</div>
                                <div class="flex-1 text-center">Melborune Victory NPL</div>
                            </div>
                        </td>
                        <td style="width: 15%" class="team-way">
                            <div class="flex space-between">
                                <div class="flex-1 text-center">Preston Lions</div>
                                <div class="text-blue-6">원</div>
                            </div>
                        </td>

                        <td><span class="text-green-3">홈님의 오버언더</span></td>
                        <td style="text-align: left !important;">
                            <span>
                                <a href="#" class="btnstyle1 btnstyle1-success h-31 mr-6">
                                    <i class="fa fa-eye text-dark" aria-hidden="true"></i>
                                </a></span> | <span>오버 (0.5)
                            </span>
                        </td>
                        <td>1.45</td>
                        <td></td>
                        <td>대기중</td>
                        {{-- <td>
                            <a href="#" class="btnstyle1 btnstyle1-warning h-31">답변완료</a>
                            <a href="#" class="btnstyle1 btnstyle1-primary h-31">답변완료</a>
                            <a href="#" class="btnstyle1 btnstyle1-danger h-31">답변완료</a>
                        </td> --}}
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

<div class="pt-10">
    <div class="p-10 bg-blue-light">
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
        </div>
        <div>
            <table class="table table-bordered cst-table-darkbrown table-history mb-0">
                <thead>
                    <tr>
                        <th style="width: 150px">경기 시간</th>
                        <th style="width: 16%">리그명</th>
                        <th style="width: 30%" colspan="2">출팁 vs 원정팀</th>
                        <th>경기타인</th>
                        <th>배팅팀&종류/기준</th>
                        <th>배달률</th>
                        <th>경기결과</th>
                        <th>배팅 결과</th>
                        {{-- <th style="width: 250px">수동처리</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-05-27 19:30:00</td>
                        <td style="text-align: left !important;"><span><i class="fa fa-futbol-o" aria-hidden="true"></i></span> | <span>VPL 1</span></td>

                        <td style="width: 15%" class="team-home">
                            <div class="flex space-between">
                                <div class="text-red-3">홈</div>
                                <div class="flex-1 text-center">Melborune Victory NPL</div>
                            </div>
                        </td>
                        <td style="width: 15%" class="team-way">
                            <div class="flex space-between">
                                <div class="flex-1 text-center">Preston Lions</div>
                                <div class="text-blue-6">원</div>
                            </div>
                        </td>

                        <td><span class="text-green-3">홈님의 오버언더</span></td>
                        <td style="text-align: left !important;">
                            <span>
                                <a href="#" class="btnstyle1 btnstyle1-success h-31 mr-6">
                                    <i class="fa fa-eye text-dark" aria-hidden="true"></i>
                                </a></span> | <span>오버 (0.5)
                            </span>
                        </td>
                        <td>1.45</td>
                        <td></td>
                        <td>대기중</td>
                        {{-- <td>
                            <a href="#" class="btnstyle1 btnstyle1-warning h-31">답변완료</a>
                            <a href="#" class="btnstyle1 btnstyle1-primary h-31">답변완료</a>
                            <a href="#" class="btnstyle1 btnstyle1-danger h-31">답변완료</a>
                        </td> --}}
                    </tr>
                    <tr>
                        <td>2024-05-27 19:30:00</td>
                        <td style="text-align: left !important;"><span><i class="fa fa-futbol-o" aria-hidden="true"></i></span> | <span>VPL 1</span></td>

                        <td style="width: 15%" class="team-home">
                            <div class="flex space-between">
                                <div class="text-red-3">홈</div>
                                <div class="flex-1 text-center">Melborune Victory NPL</div>
                            </div>
                        </td>
                        <td style="width: 15%" class="team-way">
                            <div class="flex space-between">
                                <div class="flex-1 text-center">Preston Lions</div>
                                <div class="text-blue-6">원</div>
                            </div>
                        </td>

                        <td><span class="text-green-3">홈님의 오버언더</span></td>
                        <td style="text-align: left !important;">
                            <span>
                                <a href="#" class="btnstyle1 btnstyle1-success h-31 mr-6">
                                    <i class="fa fa-eye text-dark" aria-hidden="true"></i>
                                </a></span> | <span>오버 (0.5)
                            </span>
                        </td>
                        <td>1.45</td>
                        <td></td>
                        <td>대기중</td>
                        {{-- <td>
                            <a href="#" class="btnstyle1 btnstyle1-warning h-31">답변완료</a>
                            <a href="#" class="btnstyle1 btnstyle1-primary h-31">답변완료</a>
                            <a href="#" class="btnstyle1 btnstyle1-danger h-31">답변완료</a>
                        </td> --}}
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
{{-- 3 --}}
<div class="pt-10">
    <div class="p-10 bg-blue-light">
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
        </div>
        <div>
            <table class="table table-bordered cst-table-darkbrown table-history mb-0">
                <thead>
                    <tr>
                        <th style="width: 150px">경기 시간</th>
                        <th style="width: 16%">리그명</th>
                        <th style="width: 30%" colspan="2">출팁 vs 원정팀</th>
                        <th>경기타인</th>
                        <th>배팅팀&종류/기준</th>
                        <th>배달률</th>
                        <th>경기결과</th>
                        <th>배팅 결과</th>
                        <th style="width: 180px">수동처리</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-05-27 19:30:00</td>
                        <td style="text-align: left !important;"><span><i class="fa fa-futbol-o" aria-hidden="true"></i></span> | <span>VPL 1</span></td>

                        <td style="width: 15%" class="team-home">
                            <div class="flex space-between">
                                <div class="text-red-3">홈</div>
                                <div class="flex-1 text-center">Melborune Victory NPL</div>
                            </div>
                        </td>
                        <td style="width: 15%" class="team-way">
                            <div class="flex space-between">
                                <div class="flex-1 text-center">Preston Lions</div>
                                <div class="text-blue-6">원</div>
                            </div>
                        </td>

                        <td><span class="text-green-3">홈님의 오버언더</span></td>
                        <td style="text-align: left !important;">
                            <span>
                                <a href="#" class="btnstyle1 btnstyle1-success h-31 mr-6">
                                    <i class="fa fa-eye text-dark" aria-hidden="true"></i>
                                </a></span> | <span>오버 (0.5)
                            </span>
                        </td>
                        <td>1.45</td>
                        <td></td>
                        <td>대기중</td>
                        <td>
                            <a href="#" class="btnstyle1 btnstyle1-warning h-31">적는</a>
                            <a href="#" class="btnstyle1 btnstyle1-primary h-31">당첨</a>
                            <a href="#" class="btnstyle1 btnstyle1-danger h-31">낙점</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2024-05-27 19:30:00</td>
                        <td style="text-align: left !important;"><span><i class="fa fa-futbol-o" aria-hidden="true"></i></span> | <span>VPL 1</span></td>

                        <td style="width: 15%" class="team-home">
                            <div class="flex space-between">
                                <div class="text-red-3">홈</div>
                                <div class="flex-1 text-center">Melborune Victory NPL</div>
                            </div>
                        </td>
                        <td style="width: 15%" class="team-way">
                            <div class="flex space-between">
                                <div class="flex-1 text-center">Preston Lions</div>
                                <div class="text-blue-6">원</div>
                            </div>
                        </td>

                        <td><span class="text-green-3">홈님의 오버언더</span></td>
                        <td style="text-align: left !important;">
                            <span>
                                <a href="#" class="btnstyle1 btnstyle1-success h-31 mr-6">
                                    <i class="fa fa-eye text-dark" aria-hidden="true"></i>
                                </a></span> | <span>오버 (0.5)
                            </span>
                        </td>
                        <td>1.45</td>
                        <td></td>
                        <td>대기중</td>
                        <td>
                            <a href="#" class="btnstyle1 btnstyle1-warning h-31">적는</a>
                            <a href="#" class="btnstyle1 btnstyle1-primary h-31">당첨</a>
                            <a href="#" class="btnstyle1 btnstyle1-danger h-31">낙점</a>
                        </td>
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
                <a href="#" class="btnstyle1 btnstyle1-warning h-31">배성취소</a>
            </div>
        </div>
    </div>
</div>

{{-- 4 --}}
<div class="pt-10">
    <div class="p-10 bg-blue-light">
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
        </div>
        <div>
            <table class="table table-bordered cst-table-darkbrown table-history mb-0">
                <thead>
                    <tr>
                        <th style="width: 150px">경기 시간</th>
                        <th style="width: 16%">리그명</th>
                        <th style="width: 30%" colspan="2">출팁 vs 원정팀</th>
                        <th>경기타인</th>
                        <th>배팅팀&종류/기준</th>
                        <th>배달률</th>
                        <th>경기결과</th>
                        <th>배팅 결과</th>
                        <th style="width: 180px">수동처리</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-05-27 19:30:00</td>
                        <td style="text-align: left !important;"><span><i class="fa fa-futbol-o" aria-hidden="true"></i></span> | <span>VPL 1</span></td>

                        <td style="width: 15%" class="team-home">
                            <div class="flex space-between">
                                <div class="text-red-3">홈</div>
                                <div class="flex-1 text-center">Melborune Victory NPL</div>
                            </div>
                        </td>
                        <td style="width: 15%" class="team-way">
                            <div class="flex space-between">
                                <div class="flex-1 text-center">Preston Lions</div>
                                <div class="text-blue-6">원</div>
                            </div>
                        </td>

                        <td><span class="text-green-3">홈님의 오버언더</span></td>
                        <td style="text-align: left !important;">
                            <span>
                                <a href="#" class="btnstyle1 btnstyle1-success h-31 mr-6">
                                    <i class="fa fa-eye text-dark" aria-hidden="true"></i>
                                </a></span> | <span>오버 (0.5)
                            </span>
                        </td>
                        <td>1.45</td>
                        <td></td>
                        <td>대기중</td>
                        <td>
                            <a href="#" class="btnstyle1 btnstyle1-warning h-31">적는</a>
                            <a href="#" class="btnstyle1 btnstyle1-primary h-31">당첨</a>
                            <a href="#" class="btnstyle1 btnstyle1-danger h-31">낙점</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2024-05-27 19:30:00</td>
                        <td style="text-align: left !important;"><span><i class="fa fa-futbol-o" aria-hidden="true"></i></span> | <span>VPL 1</span></td>

                        <td style="width: 15%" class="team-home">
                            <div class="flex space-between">
                                <div class="text-red-3">홈</div>
                                <div class="flex-1 text-center">Melborune Victory NPL</div>
                            </div>
                        </td>
                        <td style="width: 15%" class="team-way">
                            <div class="flex space-between">
                                <div class="flex-1 text-center">Preston Lions</div>
                                <div class="text-blue-6">원</div>
                            </div>
                        </td>

                        <td><span class="text-green-3">홈님의 오버언더</span></td>
                        <td style="text-align: left !important;">
                            <span>
                                <a href="#" class="btnstyle1 btnstyle1-success h-31 mr-6">
                                    <i class="fa fa-eye text-dark" aria-hidden="true"></i>
                                </a></span> | <span>오버 (0.5)
                            </span>
                        </td>
                        <td>1.45</td>
                        <td></td>
                        <td>대기중</td>
                        <td>
                            <a href="#" class="btnstyle1 btnstyle1-warning h-31">적는</a>
                            <a href="#" class="btnstyle1 btnstyle1-primary h-31">당첨</a>
                            <a href="#" class="btnstyle1 btnstyle1-danger h-31">낙점</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2024-05-27 19:30:00</td>
                        <td style="text-align: left !important;"><span><i class="fa fa-futbol-o" aria-hidden="true"></i></span> | <span>VPL 1</span></td>

                        <td style="width: 15%" class="team-home">
                            <div class="flex space-between">
                                <div class="text-red-3">홈</div>
                                <div class="flex-1 text-center">Melborune Victory NPL</div>
                            </div>
                        </td>
                        <td style="width: 15%" class="team-way">
                            <div class="flex space-between">
                                <div class="flex-1 text-center">Preston Lions</div>
                                <div class="text-blue-6">원</div>
                            </div>
                        </td>

                        <td><span class="text-green-3">홈님의 오버언더</span></td>
                        <td style="text-align: left !important;">
                            <span>
                                <a href="#" class="btnstyle1 btnstyle1-success h-31 mr-6">
                                    <i class="fa fa-eye text-dark" aria-hidden="true"></i>
                                </a></span> | <span>오버 <span class="text-red-3">(홈)</span>
                            </span>
                        </td>
                        <td>1.45</td>
                        <td></td>
                        <td>대기중</td>
                        <td>
                            <a href="#" class="btnstyle1 btnstyle1-warning h-31">적는</a>
                            <a href="#" class="btnstyle1 btnstyle1-primary h-31">당첨</a>
                            <a href="#" class="btnstyle1 btnstyle1-danger h-31">낙점</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2024-05-27 19:30:00</td>
                        <td style="text-align: left !important;"><span><i class="fa fa-futbol-o" aria-hidden="true"></i></span> | <span>VPL 1</span></td>

                        <td style="width: 15%" class="team-home">
                            <div class="flex space-between">
                                <div class="text-red-3">홈</div>
                                <div class="flex-1 text-center">Melborune Victory NPL</div>
                            </div>
                        </td>
                        <td style="width: 15%" class="team-way">
                            <div class="flex space-between">
                                <div class="flex-1 text-center">Preston Lions</div>
                                <div class="text-blue-6">원</div>
                            </div>
                        </td>

                        <td><span class="text-green-3">홈님의 오버언더</span></td>
                        <td style="text-align: left !important;">
                            <span>
                                <a href="#" class="btnstyle1 btnstyle1-success h-31 mr-6">
                                    <i class="fa fa-eye text-dark" aria-hidden="true"></i>
                                </a></span> | <span>오버 <span class="text-blue-6">(원)</span>
                            </span>
                        </td>
                        <td>1.45</td>
                        <td></td>
                        <td>대기중</td>
                        <td>
                            <a href="#" class="btnstyle1 btnstyle1-warning h-31">적는</a>
                            <a href="#" class="btnstyle1 btnstyle1-primary h-31">당첨</a>
                            <a href="#" class="btnstyle1 btnstyle1-danger h-31">낙점</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex space-between items-center p-8 bg-black-4 f-s-14 radius-6">
            <div class=""><strong><span class="text-light">배팅시간 : </span> <span class="text-blue-1">2024-05-27 15:35:45</span></strong></div>
            <div class="font-bold">
                <span class="text-light">3폴더 보너스 : </span>
                <span class="text-blue-1">보너스배당률 (1.03) </span>
                <span class="text-light">예상당첨금액 : </span>
                <span class="text-blue-1">(배팅금 500,000 X 배당률 19.16) = </span><span class="text-warning">9,580,000원</span> 
                <span class="text-blue-1">/</span>
                <span class="text-light"> 당첨금액 : </span>
                <span class="text-red-3">0원</span>
                <a href="#" class="btnstyle1 btnstyle1-info h-31 ml-12">정 산대기</a>
                <a href="#" class="btnstyle1 btnstyle1-danger h-31">보너스배당취소</a>
                <a href="#" class="btnstyle1 btnstyle1-warning h-31">배성취소</a>
            </div>
        </div>
    </div>
</div>
@endsection
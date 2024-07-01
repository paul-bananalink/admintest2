@extends('Admin.BettingHistories.page')
@section('content-betting-histories')
<div class="panel-heading-page flex pb-10 bottom-solid-black space-between">
    <h4 class="panel-title m-5 flex-1">
        <strong>
            <i class="fa fa-arrow-down"></i> BETTING LIST :: 미니게임 배팅관리
        </strong>
    </h4>
    @include('Admin.BettingHistories.MiniGames.search')
</div>
<div class="pt-10">
    <div class="">
        <div @class(['btnstyle1-success active-success' => true, 'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 inline-block mb-3'])>
            <a href="#" @class(['text-light flex justify-center items-center flex-1 h-full'])>
                스포츠
            </a>
        </div>
        @for ($i = 0; $i < 20; $i++)
            <div @class(['btnstyle1-success active-success' => false, 'flex btnstyle1-sm btnstyle1 btnstyle1-primary p-0 w-152 h-28 inline-block mb-3'])>
                <a href="#" @class(['text-light flex justify-center items-center flex-1 h-full'])>
                    스포츠
                </a>
            </div>
        @endfor
    </div>
</div>

<div class="mt-10">
    <table class="table table-bordered cst-table-darkbrown mb-0">
        <thead>
            <tr>
                <th>파트너명</th>
                <th>레벨</th>
                <th>아이디 (넉네임)</th>
                <th>보유머니</th>
                <th>입금수</th>
                <th>팔금수</th>
                <th>수익(입금-출금)</th>
                <th>배팅 시간</th>
                <th>게임</th>
                <th>리그</th>
                <th>배팅팀</th>
                <th>배팅금액</th>
                <th>배당률</th>
                <th>예상금액</th>
                <th>적중금액</th>
                <th>결과</th>
                <th style="width: 100px">처리상태</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>바나나부본</td>
                <td>LV <span class="text-green-1">1</span></td>
                <td>
                    <a class="text-light" href="#">
                    <i class="fa fa-cog text-blue-6 mr-12" aria-hidden="true"></i> | 
                    <span class="ml-12">devtest02 (devtest02)</span></a>
                </td>
                <td><span class="text-green-3">99,000원</span></td>
                <td><span class="text-blue-6 mr-3">90,000</span>원(3)</td>
                <td><span class="text-red-4 mr-3">0</span>원(0)</td>
                <td><span class="text-blue-3">90,000</span> 원</td>
                <td>2024-05-24 13:46:55</td>
                <td>슈어파워볼 1분</td>
                <td>일반 구간 맞추기 - 952 (3371910) 회차</td>
                <td class="text-center"><div class="ball-red-no-active">대</div></td>
                <td>5,000</td>
                <td>2.8</td>
                <td>14,000</td>
                <td>0</td>
                <td></td>
                <td><a href="#" class="btnstyle1 btnstyle1-info h-31">결 과대기</a></td>
            </tr>
            <tr>
                <td>바나나부본</td>
                <td>LV <span class="text-green-1">1</span></td>
                <td>
                    <a class="text-light" href="#">
                    <i class="fa fa-cog text-blue-6 mr-12" aria-hidden="true"></i> | 
                    <span class="ml-12">devtest02 (devtest02)</span></a>
                </td>
                <td><span class="text-green-3">99,000원</span></td>
                <td><span class="text-blue-6 mr-3">90,000</span>원(3)</td>
                <td><span class="text-red-4 mr-3">0</span>원(0)</td>
                <td><span class="text-blue-3">90,000</span> 원</td>
                <td>2024-05-24 13:46:55</td>
                <td>슈어파워볼 1분</td>
                <td>일반 구간 맞추기 - 952 (3371910) 회차</td>
                <td><div class="ball-red-active">우</div></td>
                <td>5,000</td>
                <td>2.8</td>
                <td>14,000</td>
                <td>0</td>
                <td></td>
                <td><a href="#" class="btnstyle1 btnstyle1-info h-31">결 과대기</a></td>
            </tr>
            <tr>
                <td>바나나부본</td>
                <td>LV <span class="text-green-1">1</span></td>
                <td>
                    <a class="text-light" href="#">
                    <i class="fa fa-cog text-blue-6 mr-12" aria-hidden="true"></i> | 
                    <span class="ml-12">devtest02 (devtest02)</span></a>
                </td>
                <td><span class="text-green-3">99,000원</span></td>
                <td><span class="text-blue-6 mr-3">90,000</span>원(3)</td>
                <td><span class="text-red-4 mr-3">0</span>원(0)</td>
                <td><span class="text-blue-3">90,000</span> 원</td>
                <td>2024-05-24 13:46:55</td>
                <td>슈어파워볼 1분</td>
                <td>일반 구간 맞추기 - 952 (3371910) 회차</td>
                <td><div class="ball-red-no-active">대</div></td>
                <td>5,000</td>
                <td>2.8</td>
                <td>14,000</td>
                <td>0</td>
                <td><div class="ball-blue-no-active">중</div></td>
                <td><a href="#" class="btnstyle1 btnstyle1-danger h-31">낙첨</a></td>
            </tr>
            <tr>
                <td>바나나부본</td>
                <td>LV <span class="text-green-1">1</span></td>
                <td>
                    <a class="text-light" href="#">
                    <i class="fa fa-cog text-blue-6 mr-12" aria-hidden="true"></i> | 
                    <span class="ml-12">devtest02 (devtest02)</span></a>
                </td>
                <td><span class="text-green-3">99,000원</span></td>
                <td><span class="text-blue-6 mr-3">90,000</span>원(3)</td>
                <td><span class="text-red-4 mr-3">0</span>원(0)</td>
                <td><span class="text-blue-3">90,000</span> 원</td>
                <td>2024-05-24 13:46:55</td>
                <td>슈어파워볼 1분</td>
                <td>일반 구간 맞추기 - 952 (3371910) 회차</td>
                <td><div class="ball-blue-active">3</div></td>
                <td>5,000</td>
                <td>2.8</td>
                <td>14,000</td>
                <td><span class="text-blue-3">86,000</span></td>
                <td><div class="ball-blue-active">3</div></td>
                <td><a href="#" class="btnstyle1 btnstyle1-primary h-31">당첨</a></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="mt-10">
    <table class="table table-bordered cst-table-darkbrown mb-0">
        <thead>
            <tr>
                <th>파트너명</th>
                <th>레벨</th>
                <th>아이디 (넉네임)</th>
                <th>보유머니</th>
                <th>입금수</th>
                <th>팔금수</th>
                <th>수익(입금-출금)</th>
                <th>배팅 시간</th>
                <th>게임</th>
                <th>리그</th>
                <th>배팅팀</th>
                <th>배팅금액</th>
                <th>배당률</th>
                <th>예상금액</th>
                <th>적중금액</th>
                <th>결과</th>
                <th style="width: 100px">처리상태</th>
                <th>수동처리</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>바나나부본</td>
                <td>LV <span class="text-green-1">1</span></td>
                <td>
                    <a class="text-light" href="#">
                    <i class="fa fa-cog text-blue-6 mr-12" aria-hidden="true"></i> | 
                    <span class="ml-12">devtest02 (devtest02)</span></a>
                </td>
                <td><span class="text-green-3">99,000원</span></td>
                <td><span class="text-blue-6 mr-3">90,000</span>원(3)</td>
                <td><span class="text-red-4 mr-3">0</span>원(0)</td>
                <td><span class="text-blue-3">90,000</span> 원</td>
                <td>2024-05-24 13:46:55</td>
                <td>슈어파워볼 1분</td>
                <td>일반 구간 맞추기 - 952 (3371910) 회차</td>
                <td><div class="ball-red-no-active">대</div></td>
                <td>5,000</td>
                <td>2.8</td>
                <td>14,000</td>
                <td>0</td>
                <td></td>
                <td><a href="#" class="btnstyle1 btnstyle1-info h-31">결 과대기</a></td>
                <td>
                    <a href="#" class="btnstyle1 btnstyle1-warning h-31">적득</a>
                    <a href="#" class="btnstyle1 btnstyle1-primary h-31">덩첨</a>
                    <a href="#" class="btnstyle1 btnstyle1-danger h-31">낙첨</a>
                </td>
            </tr>
            <tr>
                <td>바나나부본</td>
                <td>LV <span class="text-green-1">1</span></td>
                <td>
                    <a class="text-light" href="#">
                    <i class="fa fa-cog text-blue-6 mr-12" aria-hidden="true"></i> | 
                    <span class="ml-12">devtest02 (devtest02)</span></a>
                </td>
                <td><span class="text-green-3">99,000원</span></td>
                <td><span class="text-blue-6 mr-3">90,000</span>원(3)</td>
                <td><span class="text-red-4 mr-3">0</span>원(0)</td>
                <td><span class="text-blue-3">90,000</span> 원</td>
                <td>2024-05-24 13:46:55</td>
                <td>슈어파워볼 1분</td>
                <td>일반 구간 맞추기 - 952 (3371910) 회차</td>
                <td><div class="ball-red-active">우</div></td>
                <td>5,000</td>
                <td>2.8</td>
                <td>14,000</td>
                <td>0</td>
                <td></td>
                <td><a href="#" class="btnstyle1 btnstyle1-info h-31">결 과대기</a></td>
                <td>
                    <a href="#" class="btnstyle1 btnstyle1-warning h-31">적득</a>
                    <a href="#" class="btnstyle1 btnstyle1-primary h-31">덩첨</a>
                    <a href="#" class="btnstyle1 btnstyle1-danger h-31">낙첨</a>
                </td>
            </tr>
            <tr>
                <td>바나나부본</td>
                <td>LV <span class="text-green-1">1</span></td>
                <td>
                    <a class="text-light" href="#">
                    <i class="fa fa-cog text-blue-6 mr-12" aria-hidden="true"></i> | 
                    <span class="ml-12">devtest02 (devtest02)</span></a>
                </td>
                <td><span class="text-green-3">99,000원</span></td>
                <td><span class="text-blue-6 mr-3">90,000</span>원(3)</td>
                <td><span class="text-red-4 mr-3">0</span>원(0)</td>
                <td><span class="text-blue-3">90,000</span> 원</td>
                <td>2024-05-24 13:46:55</td>
                <td>슈어파워볼 1분</td>
                <td>일반 구간 맞추기 - 952 (3371910) 회차</td>
                <td><div class="ball-red-no-active">대</div></td>
                <td>5,000</td>
                <td>2.8</td>
                <td>14,000</td>
                <td>0</td>
                <td><div class="ball-blue-no-active">중</div></td>
                <td><a href="#" class="btnstyle1 btnstyle1-danger h-31">낙첨</a></td>
                <td>
                    <a href="#" class="btnstyle1 btnstyle1-warning h-31">적득</a>
                    <a href="#" class="btnstyle1 btnstyle1-primary h-31">덩첨</a>
                    <a href="#" class="btnstyle1 btnstyle1-danger h-31">낙첨</a>
                </td>
            </tr>
            <tr>
                <td>바나나부본</td>
                <td>LV <span class="text-green-1">1</span></td>
                <td>
                    <a class="text-light" href="#">
                    <i class="fa fa-cog text-blue-6 mr-12" aria-hidden="true"></i> | 
                    <span class="ml-12">devtest02 (devtest02)</span></a>
                </td>
                <td><span class="text-green-3">99,000원</span></td>
                <td><span class="text-blue-6 mr-3">90,000</span>원(3)</td>
                <td><span class="text-red-4 mr-3">0</span>원(0)</td>
                <td><span class="text-blue-3">90,000</span> 원</td>
                <td>2024-05-24 13:46:55</td>
                <td>슈어파워볼 1분</td>
                <td>일반 구간 맞추기 - 952 (3371910) 회차</td>
                <td><div class="ball-blue-active">3</div></td>
                <td>5,000</td>
                <td>2.8</td>
                <td>14,000</td>
                <td><span class="text-blue-3">86,000</span></td>
                <td><div class="ball-blue-active">3</div></td>
                <td><a href="#" class="btnstyle1 btnstyle1-primary h-31">당첨</a></td>
                <td>
                    <a href="#" class="btnstyle1 btnstyle1-warning h-31">돈백</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
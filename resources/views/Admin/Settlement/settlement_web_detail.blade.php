<div class="el-row">
    <div class="el-col el-col-24">
        <div class="m-10">
            @if ($row_date)
                <div class="text-left font-bold text-white f-s-16 mb-10">
                    상세정보 :: <span class="text-warning">{{ $row_date }}T00:00:00.000Z</span>
                </div>
            @endif
            <table
                class="table table-bordered table-td-valign-middle text-center text-white no-bg">
                <thead>
                    <tr>
                        <td class="text-center bg-black-darker6">구분</td>
                        <td class="text-center bg-black-darker6">배팅금(배팅수/유저수)-배팅취소액 (배팅취소수)
                        </td>
                        <td class="text-center bg-black-darker6">당첨금 (당첨수/유저수)</td>
                        <td class="text-center bg-black-darker6">승률(배팅금-당첨금)</td>
                        <td class="text-center bg-black-darker6">게임(배팅액) 수익률</td>
                        <td class="text-center bg-black-darker6">상세</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center bg-black-darker6">스포츠</td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker p-10">
                            <div class="text-gray text-left mb-3">
                                수익률 : <span
                                    style="color: #0066ff; font-weight: bold;">13</span> %
                            </div>
                            <div class="progress progress-striped active m-0 m-b-8"
                                style="height: 15px; border-radius: 4px;">
                                <div class="progress-bar progress-bar-primary"
                                    style="width: 36%"></div>
                            </div>
                        </td>
                        <td class="bg-black-darker"></td>
                    </tr>
                    <tr>
                        <td class="text-center bg-black-darker6">실시간</td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker p-10">
                            <div class="text-gray text-left mb-3">
                                수익률 : <span
                                    style="color: #0066ff; font-weight: bold;">13</span> %
                            </div>
                            <div class="progress progress-striped active m-0 m-b-8"
                                style="height: 15px; border-radius: 4px;">
                                <div class="progress-bar progress-bar-primary"
                                    style="width: 36%"></div>
                            </div>
                        </td>
                        <td class="bg-black-darker"></td>
                    </tr>
                    <tr>
                        <td class="text-center bg-black-darker6">카지노</td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker p-10">
                            <div class="text-gray text-left mb-3">
                                수익률 : <span
                                    style="color: #0066ff; font-weight: bold;">13</span> %
                            </div>
                            <div class="progress progress-striped active m-0 m-b-8"
                                style="height: 15px; border-radius: 4px;">
                                <div class="progress-bar progress-bar-primary"
                                    style="width: 36%"></div>
                            </div>
                        </td>
                        <td class="bg-black-darker"></td>
                    </tr>
                    <tr>
                        <td class="text-center bg-black-darker6">미니게임</td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker p-10">
                            <div class="text-gray text-left mb-3">
                                수익률 : <span
                                    style="color: #0066ff; font-weight: bold;">13</span> %
                            </div>
                            <div class="progress progress-striped active m-0 m-b-8"
                                style="height: 15px; border-radius: 4px;">
                                <div class="progress-bar progress-bar-primary"
                                    style="width: 36%"></div>
                            </div>
                        </td>
                        <td class="bg-black-darker">
                            <button type="button" data-toggle="collapse"
                                data-target="#SETTLEMENT_WEB_DETAIL_MINIGAME{{ $row_date }}"
                                class="btnstyle1 btnstyle1-primary btnstyle1-xs text-white">
                                <i class="fa fa-bar-chart f-s-20 m-t-2"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="m-0 p-0 height-0">
                        <td colspan="16" class="m-0 p-0 bg-black-lighter">
                            <div id="SETTLEMENT_WEB_DETAIL_MINIGAME{{ $row_date }}"
                                class="collapse width-full">
                                <div class="el-row">
                                    <div class="el-col el-col-24">
                                        <div class="m-10">
                                            <table
                                                class="table table-bordered table-td-valign-middle text-center text-white no-bg">
                                                <thead>
                                                    <tr>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            구분
                                                        </td>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            배팅금(배팅수/유저수)-배팅취소액 (배팅취소수)
                                                        </td>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            당첨금 (당첨수/유저수)
                                                        </td>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            승률(배팅금-당첨금)
                                                        </td>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            게임(배팅액) 수익률
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center bg-black-darker6">스포츠</td>
                                                        <td class="bg-black-darker"></td>
                                                        <td class="bg-black-darker"></td>
                                                        <td class="bg-black-darker"></td>
                                                        <td class="bg-black-darker p-10">
                                                            <div class="text-gray text-left mb-3">
                                                                수익률 : <span
                                                                    style="color: #0066ff; font-weight: bold;">13</span> %
                                                            </div>
                                                            <div class="progress progress-striped active m-0 m-b-8"
                                                                style="height: 15px; border-radius: 4px;">
                                                                <div class="progress-bar progress-bar-primary"
                                                                    style="width: 36%"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center bg-black-darker6">가상스포츠</td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker p-10">
                            <div class="text-gray text-left mb-3">
                                수익률 : <span
                                    style="color: #0066ff; font-weight: bold;">13</span> %
                            </div>
                            <div class="progress progress-striped active m-0 m-b-8"
                                style="height: 15px; border-radius: 4px;">
                                <div class="progress-bar progress-bar-primary"
                                    style="width: 36%"></div>
                            </div>
                        </td>
                        <td class="bg-black-darker">
                            <button type="button" data-toggle="collapse"
                                data-target="#SETTLEMENT_WEB_DETAIL_VIRTUAL_SPORTS{{ $row_date }}"
                                class="btnstyle1 btnstyle1-primary btnstyle1-xs text-white">
                                <i class="fa fa-bar-chart f-s-20 m-t-2"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="m-0 p-0 height-0">
                        <td colspan="16" class="m-0 p-0 bg-black-lighter">
                            <div id="SETTLEMENT_WEB_DETAIL_VIRTUAL_SPORTS{{ $row_date }}"
                                class="collapse width-full">
                                <div class="el-row">
                                    <div class="el-col el-col-24">
                                        <div class="m-10">
                                            <table
                                                class="table table-bordered table-td-valign-middle text-center text-white no-bg">
                                                <thead>
                                                    <tr>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            구분
                                                        </td>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            배팅금(배팅수/유저수)-배팅취소액 (배팅취소수)
                                                        </td>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            당첨금 (당첨수/유저수)
                                                        </td>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            승률(배팅금-당첨금)
                                                        </td>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            게임(배팅액) 수익률
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center bg-black-darker6">스포츠</td>
                                                        <td class="bg-black-darker"></td>
                                                        <td class="bg-black-darker"></td>
                                                        <td class="bg-black-darker"></td>
                                                        <td class="bg-black-darker p-10">
                                                            <div class="text-gray text-left mb-3">
                                                                수익률 : <span
                                                                    style="color: #0066ff; font-weight: bold;">13</span> %
                                                            </div>
                                                            <div class="progress progress-striped active m-0 m-b-8"
                                                                style="height: 15px; border-radius: 4px;">
                                                                <div class="progress-bar progress-bar-primary"
                                                                    style="width: 36%"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center bg-black-darker6">파싱 카지노</td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker"></td>
                        <td class="bg-black-darker p-10">
                            <div class="text-gray text-left mb-3">
                                수익률 : <span
                                    style="color: #0066ff; font-weight: bold;">13</span> %
                            </div>
                            <div class="progress progress-striped active m-0 m-b-8"
                                style="height: 15px; border-radius: 4px;">
                                <div class="progress-bar progress-bar-primary"
                                    style="width: 36%"></div>
                            </div>
                        </td>
                        <td class="bg-black-darker">
                            <button type="button" data-toggle="collapse"
                                data-target="#SETTLEMENT_WEB_DETAIL_PARSING_CASINO{{ $row_date }}"
                                class="btnstyle1 btnstyle1-primary btnstyle1-xs text-white">
                                <i class="fa fa-bar-chart f-s-20 m-t-2"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="m-0 p-0 height-0">
                        <td colspan="16" class="m-0 p-0 bg-black-lighter">
                            <div id="SETTLEMENT_WEB_DETAIL_PARSING_CASINO{{ $row_date }}"
                                class="collapse width-full">
                                <div class="el-row">
                                    <div class="el-col el-col-24">
                                        <div class="m-10">
                                            <table
                                                class="table table-bordered table-td-valign-middle text-center text-white no-bg">
                                                <thead>
                                                    <tr>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            구분
                                                        </td>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            배팅금(배팅수/유저수)-배팅취소액 (배팅취소수)
                                                        </td>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            당첨금 (당첨수/유저수)
                                                        </td>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            승률(배팅금-당첨금)
                                                        </td>
                                                        <td
                                                            class="text-center bg-black-darker6">
                                                            게임(배팅액) 수익률
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center bg-black-darker6">스포츠</td>
                                                        <td class="bg-black-darker"></td>
                                                        <td class="bg-black-darker"></td>
                                                        <td class="bg-black-darker"></td>
                                                        <td class="bg-black-darker p-10">
                                                            <div class="text-gray text-left mb-3">
                                                                수익률 : <span
                                                                    style="color: #0066ff; font-weight: bold;">13</span> %
                                                            </div>
                                                            <div class="progress progress-striped active m-0 m-b-8"
                                                                style="height: 15px; border-radius: 4px;">
                                                                <div class="progress-bar progress-bar-primary"
                                                                    style="width: 36%"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center bg-black-4">현재합계</td>
                        <td class="bg-black-4"></td>
                        <td class="bg-black-4"></td>
                        <td class="bg-black-4"></td>
                        <td class="bg-black-4 p-10">
                            <div class="text-gray text-left mb-3">
                                수익률 : <span
                                    style="color: #0066ff; font-weight: bold;">13</span> %
                            </div>
                            <div class="progress progress-striped active m-0 m-b-8"
                                style="height: 30px; border-radius: 4px;">
                                <div class="progress-bar progress-bar-success"
                                    style="width: 36%"></div>
                            </div>
                        </td>
                        <td class="bg-black-4"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
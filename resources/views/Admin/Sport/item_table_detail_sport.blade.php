<table class="table table-bordered cst-table-darkbrown mb-0 table-sport-mana" id="form_sport_score_{{ $item->idx }}">
    <thead>
        <tr>
            <th style="width: 44px">{{ $item->sports_name }}</th>

            <th style="width: 44px">1이닝</th>
            <th style="width: 44px">2이닝</th>
            <th style="width: 44px">3이닝</th>
            <th style="width: 44px">4이닝</th>
            <th style="width: 44px">5이닝</th>
            <th style="width: 44px">6이닝</th>
            <th style="width: 44px">7이닝</th>
            <th style="width: 44px">8이닝</th>
            <th style="width: 44px">9이닝</th>

            <th style="width: 44px">F.T</th>
            <th style="width: 44px">O.T</th>

            <th style="width: 90px"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>홈팀</td>

            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="home_score[1]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="home_score[2]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="home_score[3]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="home_score[4]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="home_score[5]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="home_score[6]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="home_score[7]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="home_score[8]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="home_score[9]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="home_score[ft]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="home_score[ot]" value=""></td>

            <td rowspan="2">
               <div class="" style="transform: rotate(-90deg)">
                    <div class="mb-3">
                        <a style="width: 89px;padding: 3px 0;" class="btnstyle1 btnstyle1-success h-28">결과오입력</a>
                    </div>
                    <div class="mb-3">
                        <a style="width: 89px;padding: 3px 0;" class="btnstyle1 btnstyle1-warning h-28">적중특례</a>
                    </div>
                    
                    <div class="mb-3">
                        <a style="width: 89px;padding: 3px 0;" class="btnstyle1 btnstyle1-danger h-28">롤백기능</a>
                    </div>
               </div>
            </td>
        </tr>

        <tr>
            <td>원정</td>

            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="away_score[1]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="away_score[2]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="away_score[3]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="away_score[4]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="away_score[5]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="away_score[6]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="away_score[7]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="away_score[8]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="away_score[9]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="away_score[ft]" value=""></td>
            <td><input type="text" class="formatPercent form-control p-0 text-center bg-white" name="away_score[ot]" value=""></td>

        </tr>
    </tbody>
</table>
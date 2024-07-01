<?php

namespace App\Http\Controllers\Admin\PageSetting;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
  public function index(){
    $exchangerate = ExchangeRate::first();
    return view('Admin.PageSetting.ExchangeRate.index_exchange_rate', compact('exchangerate'));
  }

  public function update(Request $request)
    {
        $exchangerate =  ExchangeRate::first();
        $exchangerate->update($request->all());
        if($exchangerate){
          return redirect()->route('admin.page-setting.exchange-rate.indexExchangeRate', $exchangerate)->with('success', '업데이트 성공');
        }
        return redirect()->route('admin.page-setting.exchange-rate.indexExchangeRate', $exchangerate)->with('error', '업데이트 실패');  
    }
}

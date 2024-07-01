<?php

namespace App\Http\Controllers\Partner\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        return view('Partner.Coupon.index');
    }
}

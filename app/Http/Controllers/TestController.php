<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Carbon\Carbon;

class TestController extends Controller
{


    public function test(){

        return Carbon::parse('2017/9/3');
    }
}

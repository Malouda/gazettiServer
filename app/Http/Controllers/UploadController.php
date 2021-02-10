<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{

    public function Upload(Request $request){

       $path = $request->file('file')->store('images/coverImages');

       return $path;
    }
}

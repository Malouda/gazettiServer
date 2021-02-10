<?php

namespace App\Http\Controllers;

use App\Helpers\Email\EmailViewComponent;
use App\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ViewsController extends Controller
{

    public function sendViews(Request $request,EmailViewComponent $emailViewComponent){

        $user=$request->user();
        $user=$user->fname.' '.$user->lname;
        $publisher_id=$request->publisher;

        if($publisher_id==='gazetti'){

            $emailViewComponent->sendEmail($request->subject,$request->views,$user,'gazetticlubtz@gmail.com');

        }else{

            $publisher=Publisher::where('id','=',$publisher_id)->first();
            $emailViewComponent->sendEmail($request->subject,$request->views,$user,$publisher->email);

        }
    }
}

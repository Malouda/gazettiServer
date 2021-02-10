<?php

namespace App\Http\Controllers;

use App\Helpers\Sms\SmsComponent;
use App\Invite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InviteController extends Controller
{

    public function invite(Request $request,SmsComponent $smsComponent){

        $letter = chr(rand(65,90));
        $number=rand(100, 999);
        $token=$number.$letter;

        $email=$request->email;


        Invite::create([
            'inviter_id'=>1,
            'invited_id'=>2,
            'invited_phone'=>$request->phone,
            'group_id'=>$request->groupname_id,
            'publisher_id'=>$request->publisher,
            'token'=>$token,
            'publication_id'=>$request->publication_id
        ]);


        if($email){

            $smsComponent->sendSms($phone=null,$email,$token);

        }else{

            $smsComponent->sendSms($request->phone,$email=null,$token);
        }

    }
}
